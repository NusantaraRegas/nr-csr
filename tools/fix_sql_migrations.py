#!/usr/bin/env python3
"""
Script to convert uppercase SQL identifiers to lowercase in migration files.
"""
import os
import re

def fix_sql_statements(content):
    """Convert uppercase SQL identifiers to lowercase, but preserve specific uppercase columns."""
    # List of columns that should remain uppercase (as they are in the database)
    uppercase_cols = ['CATATAN1', 'CATATAN1_NEW', 'CATATAN2', 'CATATAN2_NEW',
                      'COLUMN1', 'COLUMN2', 'COLUMN3',
                      'EVALUATOR1', 'EVALUATOR2', 
                      'KET_KADIN1', 'KET_KADIN2',
                      'PARAMETER1', 'PARAMETER2', 'PARAMETER3', 'PARAMETER4', 'PARAMETER5',
                      'PERSEN1', 'PERSEN2', 'PERSEN3', 'PERSEN4', 
                      'RUPIAH1', 'RUPIAH2', 'RUPIAH3', 'RUPIAH4',
                      'SURVEI1', 'SURVEI2']
    
    # Replace quoted schema.table.column patterns: "NR_CSR"."TBL_X"."COL" -> nr_csr.tbl_x.col
    content = re.sub(r'"NR_CSR"\."([A-Z_]+)"\."([A-Z_]+)"', lambda m: f'nr_csr.{m.group(1).lower()}.{m.group(2).lower()}', content)
    
    # Replace quoted schema.table patterns: "NR_CSR"."TBL_X" -> nr_csr.tbl_x
    content = re.sub(r'"NR_CSR"\."([A-Z_]+)"', lambda m: f'nr_csr.{m.group(1).lower()}', content)
    
    # Replace ALL quoted uppercase identifiers EXCEPT the ones in our uppercase_cols list
    def replace_identifier(match):
        full_match = match.group(0)
        identifier = match.group(1)
        
        # Keep uppercase columns as quoted uppercase
        if identifier in uppercase_cols:
            return f'."{identifier}"' if full_match.startswith('.') else f'"{identifier}"'
        # Convert others to lowercase without quotes
        else:
            return f'.{identifier.lower()}' if full_match.startswith('.') else identifier.lower()
    
    content = re.sub(r'\.?"([A-Z_][A-Z0-9_]*)"', replace_identifier, content)
    
    # Fix search_path
    content = content.replace('SET search_path TO "NR_CSR"', 'SET search_path TO nr_csr')
    content = content.replace('SET search_path TO public', 'SET search_path TO nr_csr, public')
    
    return content

def fix_migration_file(filepath):
    """Fix SQL statements in a migration file."""
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    content = fix_sql_statements(content)
    
    if content != original_content:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        return True
    return False

def main():
    """Main function."""
    files_to_fix = [
        'database/migrations/2026_01_12_000132_create_nr_csr_views.php',
    ]
    
    modified_count = 0
    for filepath in files_to_fix:
        if os.path.exists(filepath):
            if fix_migration_file(filepath):
                print(f"✓ Fixed: {filepath}")
                modified_count += 1
            else:
                print(f"- Skipped: {filepath} (no changes needed)")
        else:
            print(f"✗ Not found: {filepath}")
    
    print(f"\nModified {modified_count} files")

if __name__ == '__main__':
    main()
