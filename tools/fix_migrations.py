#!/usr/bin/env python3
"""
Script to convert uppercase column names to lowercase in Laravel migration files.
"""
import os
import re
import glob

def fix_migration_file(filepath):
    """Convert uppercase column names to lowercase in a migration file."""
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    
    # Pattern to match $table->column_type('UPPERCASE_NAME')
    # Match patterns like: $table->string('COLUMN_NAME', ...
    pattern = r"(\$table->\w+\()(['\"])([A-Z_]+)(['\"])"
    
    def replace_func(match):
        prefix = match.group(1)  # $table->type(
        quote1 = match.group(2)  # ' or "
        column_name = match.group(3)  # COLUMN_NAME
        quote2 = match.group(4)  # ' or "
        
        # Convert to lowercase
        lowercase_name = column_name.lower()
        
        return f"{prefix}{quote1}{lowercase_name}{quote2}"
    
    # Replace all occurrences
    content = re.sub(pattern, replace_func, content)
    
    # Also fix Schema::create patterns with uppercase table references
    # e.g., 'NR_CSR.TBL_TABLE' -> 'nr_csr.tbl_table'
    schema_pattern = r"(['\"])NR_CSR\.([A-Z_]+)(['\"])"
    
    def schema_replace(match):
        quote1 = match.group(1)
        table_name = match.group(2)
        quote2 = match.group(3)
        return f"{quote1}nr_csr.{table_name.lower()}{quote2}"
    
    content = re.sub(schema_pattern, schema_replace, content)
    
    # Only write if content changed
    if content != original_content:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        return True
    return False

def main():
    """Main function to process all migration files."""
    migration_dir = 'database/migrations'
    
    # Get all PHP migration files
    migration_files = glob.glob(os.path.join(migration_dir, '*.php'))
    
    print(f"Found {len(migration_files)} migration files")
    
    modified_count = 0
    for filepath in migration_files:
        if fix_migration_file(filepath):
            print(f"✓ Fixed: {os.path.basename(filepath)}")
            modified_count += 1
        else:
            print(f"- Skipped: {os.path.basename(filepath)} (no changes needed)")
    
    print(f"\nModified {modified_count} files")

if __name__ == '__main__':
    main()
