import json
import re
from dataclasses import dataclass
from datetime import datetime
from pathlib import Path
from typing import Optional


@dataclass
class Column:
    name: str
    sql_type: str
    not_null: bool
    default: Optional[str]


def studly(s: str) -> str:
    parts = re.split(r"[^a-zA-Z0-9]+", s.lower())
    return "".join(p.capitalize() for p in parts if p)


def ts_prefix(i: int) -> str:
    # Deterministic migration timestamps so ordering is stable in git
    base = datetime(2026, 1, 12, 0, 0, 0)
    dt = base.replace(minute=i // 60, second=i % 60)
    return dt.strftime("%Y_%m_%d_%H%M%S")


def quote_ident(name: str) -> str:
    # For SQL identifiers in DB::statement strings
    return '"' + name.replace('"', '""') + '"'


def map_sql_type_to_blueprint(col: Column):
    t = col.sql_type.upper().strip()
    name = col.name

    # PostgreSQL types we see in the dump
    if t in ("INTEGER", "INT", "INT4"):
        return f"$table->integer('{name}')"
    if t in ("BIGINT", "INT8"):
        return f"$table->bigInteger('{name}')"
    if t.startswith("VARCHAR"):
        m = re.search(r"VARCHAR\((\d+)\)", t)
        if m:
            return f"$table->string('{name}', {int(m.group(1))})"
        return f"$table->string('{name}')"
    if t == "TEXT":
        return f"$table->text('{name}')"
    if t.startswith("NUMERIC") or t.startswith("DECIMAL"):
        m = re.search(r"NUMERIC\((\d+)\s*,\s*(\d+)\)", t)
        if m:
            return f"$table->decimal('{name}', {int(m.group(1))}, {int(m.group(2))})"
        return f"$table->decimal('{name}', 18, 2)"  # fallback
    if t in ("TIMESTAMP", "TIMESTAMPTZ"):
        return f"$table->timestamp('{name}')"
    if t == "DATE":
        return f"$table->date('{name}')"

    # Types that are Oracle-ish leftovers in the dump (LONG). Map to text.
    if t == "LONG":
        return f"$table->text('{name}')"

    # Fallback: use text so migration can run
    return f"$table->text('{name}')"


def apply_nullability(stmt: str, col: Column) -> str:
    if not col.not_null:
        stmt += "->nullable()"
    return stmt


def apply_default(stmt: str, col: Column) -> str:
    if col.default is None:
        return stmt
    d = col.default.strip()
    if d.upper() == "NULL":
        return stmt  # nullable handled elsewhere
    # Support empty string defaults like ''
    if d == "''":
        return stmt + "->default('')"
    # If it's a quoted string literal
    if len(d) >= 2 and d[0] == "'" and d[-1] == "'":
        # naive unescape
        v = d[1:-1].replace("''", "'")
        v = v.replace("\\", "\\\\").replace("'", "\\'")
        return stmt + f"->default('{v}')"
    # Numeric default
    if re.fullmatch(r"-?\d+(?:\.\d+)?", d):
        return stmt + f"->default({d})"
    # otherwise: raw default is risky; skip
    return stmt


def write_file(path: Path, content: str):
    path.parent.mkdir(parents=True, exist_ok=True)
    path.write_text(content, encoding="utf-8")


def main():
    root = Path(__file__).resolve().parents[1]
    schema_json_path = root / "tools" / "nr_csr_schema.json"
    data = json.loads(schema_json_path.read_text(encoding="utf-8"))

    # Only handle NR_CSR tables for now (NR_PAYMENT objects are external)
    tables = [t for t in data["tables"] if t["schema"] == "NR_CSR"]

    # Build PK map
    pk_map = {(p["schema"], p["table"]): p["columns"] for p in data["primary_keys"]}
    unique_constraints = [u for u in data["unique_constraints"] if u["schema"] == "NR_CSR"]
    indexes = [i for i in data["indexes"] if i["schema"] == "NR_CSR"]
    views = [v for v in data["views"] if v["schema"] == "NR_CSR"]
    fks = [f for f in data["foreign_keys"] if f["schema"] == "NR_CSR"]

    mig_dir = root / "database" / "migrations"

    # 1) schemas
    schemas_content = """<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Support\\Facades\\DB;

class CreateNrCsrSchemas extends Migration
{
    public function up()
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS "NR_CSR"');
        DB::statement('CREATE SCHEMA IF NOT EXISTS "NR_PAYMENT"');
    }

    public function down()
    {
        // Keep schemas by default to avoid accidental data loss.
        // DB::statement('DROP SCHEMA IF EXISTS "NR_CSR" CASCADE');
        // DB::statement('DROP SCHEMA IF EXISTS "NR_PAYMENT" CASCADE');
    }
}
"""
    write_file(mig_dir / f"{ts_prefix(1)}_create_nr_csr_schemas.php", schemas_content)

    # 2) tables
    table_classes = []
    for t in tables:
        table_name = t["name"]
        class_name = f"CreateNrCsr{studly(table_name)}Table"

        cols = [Column(c["name"], c["type"], bool(c["not_null"]), c.get("default")) for c in t["columns"]]
        pk_cols = pk_map.get(("NR_CSR", table_name), [])

        lines = []
        lines.append(f"Schema::create('NR_CSR.{table_name}', function (Blueprint $table) {{")

        for c in cols:
            # If single-column PK, use identity column.
            if len(pk_cols) == 1 and pk_cols[0] == c.name:
                # Choose bigIncrements when the column is BIGINT, else increments.
                if c.sql_type.upper().startswith("BIGINT"):
                    stmt = f"$table->bigIncrements('{c.name}')"
                else:
                    stmt = f"$table->increments('{c.name}')"
                lines.append(f"            {stmt};")
                continue

            stmt = map_sql_type_to_blueprint(c)
            stmt = apply_nullability(stmt, c)
            # Apply safe defaults (NULL handled, simple strings/numerics supported)
            stmt = apply_default(stmt, c)
            lines.append(f"            {stmt};")

        # Composite PKs
        if len(pk_cols) > 1:
            cols_list = ", ".join([f"'{c}'" for c in pk_cols])
            lines.append(f"            $table->primary([{cols_list}]);")

        lines.append("        });")

        table_classes.append(
            (table_name, class_name, "\n".join(lines))
        )

    # split into a few files to avoid huge single migration
    chunk_size = 10
    for idx in range(0, len(table_classes), chunk_size):
        chunk = table_classes[idx : idx + chunk_size]
        class_name = f"CreateNrCsrTablesPart{idx // chunk_size + 1}"
        body_lines = []
        for _, _, create_stmt in chunk:
            body_lines.append(create_stmt)
            body_lines.append("")

        down_lines = []
        for table_name, _, _ in reversed(chunk):
            down_lines.append(f"Schema::dropIfExists('NR_CSR.{table_name}');")

        content = """<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

class {class_name} extends Migration
{{
    public function up()
    {{
{up_body}
    }}

    public function down()
    {{
{down_body}
    }}
}}
""".format(
            class_name=class_name,
            up_body="\n".join(["        " + l if l else "" for l in "\n".join(body_lines).splitlines()]),
            down_body="\n".join(["        " + l for l in down_lines]),
        )

        write_file(mig_dir / f"{ts_prefix(10 + idx // chunk_size)}_create_nr_csr_tables_part_{idx // chunk_size + 1}.php", content)

    # 3) constraints/indexes
    constraints_lines = [
        "<?php",
        "",
        "use Illuminate\\Database\\Migrations\\Migration;",
        "use Illuminate\\Support\\Facades\\DB;",
        "",
        "class AddNrCsrConstraintsAndIndexes extends Migration",
        "{",
        "    public function up()",
        "    {",
    ]

    # Unique constraints
    for u in unique_constraints:
        cols = ", ".join([quote_ident(c) for c in u["columns"]])
        tbl = f"{quote_ident('NR_CSR')}.{quote_ident(u['table'])}"
        name = quote_ident(u["constraint"])
        constraints_lines.append(
            f"        DB::statement('ALTER TABLE {tbl} ADD CONSTRAINT {name} UNIQUE ({cols})');"
        )

    # Indexes
    for ix in indexes:
        cols = ", ".join([quote_ident(c) for c in ix["columns"]])
        tbl = f"{quote_ident('NR_CSR')}.{quote_ident(ix['table'])}"
        idx_name = f"{quote_ident(ix['index_schema'])}.{quote_ident(ix['name'])}"
        unique = "UNIQUE " if ix.get("unique") else ""
        constraints_lines.append(
            f"        DB::statement('CREATE {unique}INDEX {idx_name} ON {tbl} ({cols})');"
        )

    constraints_lines += [
        "    }",
        "",
        "    public function down()",
        "    {",
        "        // Dropping constraints/indexes is intentionally omitted (safety).",
        "    }",
        "}",
        "",
    ]

    write_file(mig_dir / f"{ts_prefix(90)}_add_nr_csr_constraints_and_indexes.php", "\n".join(constraints_lines))

    # 4) foreign keys TODO (we don't know references from dump)
    fk_lines = [
        "<?php",
        "",
        "use Illuminate\\Database\\Migrations\\Migration;",
        "",
        "class AddNrCsrForeignKeysTodo extends Migration",
        "{",
        "    public function up()",
        "    {",
        "        // TODO: The provided SQL dump does not include referenced table/columns for FKs.",
        "        // Fill these once references are confirmed.",
    ]
    for fk in fks:
        fk_lines.append(
            f"        // {fk['constraint']}: NR_CSR.{fk['table']}.{fk['column']} -> ???"
        )
    fk_lines += [
        "    }",
        "",
        "    public function down()",
        "    {",
        "    }",
        "}",
        "",
    ]
    write_file(mig_dir / f"{ts_prefix(91)}_add_nr_csr_foreign_keys_todo.php", "\n".join(fk_lines))

    # 5) views
    # Escape single quotes for DB::statement.
    view_lines = [
        "<?php",
        "",
        "use Illuminate\\Database\\Migrations\\Migration;",
        "use Illuminate\\Support\\Facades\\DB;",
        "",
        "class CreateNrCsrViews extends Migration",
        "{",
        "    public function up()",
        "    {",
    ]
    for v in views:
        view_sql = f"CREATE OR REPLACE VIEW \"NR_CSR\".\"{v['name']}\" AS {v['sql']}"
        view_sql = view_sql.replace("'", "''")
        view_lines.append(f"        DB::statement('{view_sql}');")
    view_lines += [
        "    }",
        "",
        "    public function down()",
        "    {",
        "        // Optional: drop views",
        "        // DB::statement('DROP VIEW IF EXISTS ...');",
        "    }",
        "}",
        "",
    ]
    write_file(mig_dir / f"{ts_prefix(92)}_create_nr_csr_views.php", "\n".join(view_lines))

    print(f"Generated migrations into {mig_dir}")


if __name__ == "__main__":
    main()
