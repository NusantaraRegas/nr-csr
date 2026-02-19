-- Set the search_path for the nrcsr_user user so it automatically finds tables in NR_CSR schema
-- NOTE: We normalize schema names to lowercase for Postgres/Laravel compatibility.
ALTER ROLE nrcsr_user SET search_path TO nr_csr, public;
