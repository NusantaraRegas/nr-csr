from pathlib import Path
import re


ROOT = Path(__file__).resolve().parents[1]


def migrate_routes() -> int:
    route_file = ROOT / "routes" / "web.php"
    text = route_file.read_text(encoding="utf-8")
    pattern = re.compile(
        r"Route::get\((\s*['\"][^'\"]*(?:delete|hapus|destroy|remove)[^'\"]*['\"]\s*,)",
        flags=re.IGNORECASE,
    )
    new_text, count = pattern.subn(r"Route::delete(\1", text)
    if count:
        route_file.write_text(new_text, encoding="utf-8")
    return count


def migrate_views() -> int:
    views_dir = ROOT / "resources" / "views"
    total = 0
    # Replace destructive redirects with CSRF-protected DELETE form submit helper.
    pattern = re.compile(r"window\.location\s*=\s*(?P<expr>[^;\n]*?(?:delete|hapus|destroy|remove)[^;\n]*?)\s*;")

    for path in views_dir.rglob("*.blade.php"):
        text = path.read_text(encoding="utf-8")
        new_text, count = pattern.subn(r"submitDelete(\g<expr>);", text)
        if count:
            path.write_text(new_text, encoding="utf-8")
            total += count

    return total


def main() -> None:
    route_count = migrate_routes()
    view_count = migrate_views()
    print(f"route_changes={route_count}")
    print(f"view_changes={view_count}")


if __name__ == "__main__":
    main()
