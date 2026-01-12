import json
import re
from pathlib import Path


def split_columns(cols_block: str):
    """Split a CREATE TABLE column block into individual column definition lines.

    This is intentionally simple and tailored to the provided dump:
    - Columns are defined one per line
    - No complex nested parentheses except type precision like NUMERIC(38,0)
    """
    lines = []
    for raw in cols_block.splitlines():
        s = raw.strip().rstrip(",")
        if not s:
            continue
        lines.append(s)
    return lines


def parse_column(line: str):
    # Example: "ID_ANGGARAN" NUMERIC NOT NULL
    m = re.match(r'^"(?P<name>[^"]+)"\s+(?P<type>[^\s]+(?:\([^\)]*\))?)(?P<rest>.*)$', line)
    if not m:
        return None
    name = m.group("name")
    col_type = m.group("type")
    rest = m.group("rest") or ""
    not_null = bool(re.search(r"\bNOT\s+NULL\b", rest, re.I))
    default = None
    md = re.search(r"\bDEFAULT\s+([^\s,]+(?:\s*'[^']*')?)", rest, re.I)
    if md:
        default = md.group(1).strip()
    return {"name": name, "type": col_type, "not_null": not_null, "default": default}


def main():
    sql_path = Path(__file__).resolve().parents[1] / "NR_CSR.sql"
    sql = sql_path.read_text(encoding="utf-8", errors="ignore")

    out = {
        "schemas": [],
        "tables": [],
        "primary_keys": [],
        "unique_constraints": [],
        "indexes": [],
        "foreign_keys": [],
        "views": [],
    }

    # Schemas
    for m in re.finditer(r'CREATE\s+SCHEMA\s+IF\s+NOT\s+EXISTS\s+"(?P<schema>[^"]+)"\s*;', sql, flags=re.I):
        out["schemas"].append(m.group("schema"))

    # Tables
    for m in re.finditer(
        r'CREATE\s+TABLE\s+"(?P<schema>[^"]+)"\."(?P<table>[^"]+)"\s*\((?P<cols>.*?)\)\s*;',
        sql,
        flags=re.I | re.S,
    ):
        cols = []
        for line in split_columns(m.group("cols")):
            c = parse_column(line)
            if c:
                cols.append(c)
        out["tables"].append({"schema": m.group("schema"), "name": m.group("table"), "columns": cols})

    # PKs
    for m in re.finditer(
        r'ALTER\s+TABLE\s+"(?P<schema>[^"]+)"\."(?P<table>[^"]+)"\s+ADD\s+CONSTRAINT\s+"(?P<constraint>[^"]+)"\s+PRIMARY\s+KEY\s*\((?P<cols>[^\)]*)\)\s*;',
        sql,
        flags=re.I,
    ):
        cols = re.findall(r'"([^"]+)"', m.group("cols"))
        out["primary_keys"].append({"schema": m.group("schema"), "table": m.group("table"), "constraint": m.group("constraint"), "columns": cols})

    # Unique constraints
    for m in re.finditer(
        r'ALTER\s+TABLE\s+"(?P<schema>[^"]+)"\."(?P<table>[^"]+)"\s+ADD\s+CONSTRAINT\s+"(?P<constraint>[^"]+)"\s+UNIQUE\s*\((?P<cols>[^\)]*)\)\s*;',
        sql,
        flags=re.I,
    ):
        cols = re.findall(r'"([^"]+)"', m.group("cols"))
        out["unique_constraints"].append({"schema": m.group("schema"), "table": m.group("table"), "constraint": m.group("constraint"), "columns": cols})

    # Indexes (CREATE UNIQUE INDEX ... ON "schema"."table" ("COL" ASC))
    for m in re.finditer(
        r'CREATE\s+(?P<unique>UNIQUE\s+)?INDEX\s+"(?P<schema>[^"]+)"\."(?P<index>[^"]+)"\s+ON\s+"(?P<tschema>[^"]+)"\."(?P<table>[^"]+)"\s*\((?P<cols>[^\)]*)\)\s*;',
        sql,
        flags=re.I,
    ):
        cols = re.findall(r'"([^"]+)"', m.group("cols"))
        out["indexes"].append(
            {
                "schema": m.group("tschema"),
                "table": m.group("table"),
                "index_schema": m.group("schema"),
                "name": m.group("index"),
                "unique": bool(m.group("unique")),
                "columns": cols,
            }
        )

    # Foreign keys (dump omits referenced table/cols; we at least capture local column and constraint name)
    for m in re.finditer(
        r'ALTER\s+TABLE\s+"(?P<schema>[^"]+)"\."(?P<table>[^"]+)"\s+ADD\s+CONSTRAINT\s+"(?P<constraint>[^"]+)"\s+FOREIGN\s+KEY\s*\("(?P<col>[^"]+)"\)\s*;',
        sql,
        flags=re.I,
    ):
        out["foreign_keys"].append(
            {"schema": m.group("schema"), "table": m.group("table"), "constraint": m.group("constraint"), "column": m.group("col")}
        )

    # Views (simple: CREATE OR REPLACE VIEW "schema"."name" AS <select>;)
    for m in re.finditer(
        r'CREATE\s+OR\s+REPLACE\s+VIEW\s+"(?P<schema>[^"]+)"\."(?P<view>[^"]+)"\s+AS\s+(?P<select>.*?);\s*',
        sql,
        flags=re.I | re.S,
    ):
        out["views"].append({"schema": m.group("schema"), "name": m.group("view"), "sql": " ".join(m.group("select").split())})

    out_path = Path(__file__).resolve().parents[1] / "tools" / "nr_csr_schema.json"
    out_path.parent.mkdir(parents=True, exist_ok=True)
    out_path.write_text(json.dumps(out, indent=2), encoding="utf-8")
    print(f"Wrote {out_path}")


if __name__ == "__main__":
    main()

