-- Set the search_path for the nr_csr user so it automatically finds tables in NR_CSR schema
-- NOTE: We normalize schema names to lowercase for Postgres/Laravel compatibility.
ALTER ROLE nr_csr SET search_path TO nr_csr, public;
