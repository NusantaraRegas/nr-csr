-- Normalize NR_CSR / NR_PAYMENT schemas to lowercase, unquoted identifiers
-- This script renames schemas, tables, columns, and sequences to lowercase.
--
-- IMPORTANT:
-- 1) Take a backup before running.
-- 2) Run when application traffic is stopped.
--

BEGIN;

-- 1) Rename schemas
ALTER SCHEMA "NR_CSR" RENAME TO nr_csr;
ALTER SCHEMA "NR_PAYMENT" RENAME TO nr_payment;

-- 2) Rename tables (schema names above are now lowercase)
\i rename_tables.sql

-- 3) Rename columns
\i rename_columns.sql

-- 4) Rename sequences
\i rename_sequences.sql

COMMIT;
