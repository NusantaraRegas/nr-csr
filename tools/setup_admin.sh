#!/bin/bash
set -euo pipefail

# Script to create/update a local admin user inside PostgreSQL container.
# Required:
#   ADMIN_PASSWORD_HASH -> bcrypt hash (do not put plaintext passwords in this file)
# Optional:
#   DB_USER (default: nr_csr)
#   DB_NAME (default: nr_csr)
#   ADMIN_USERNAME (default: admin)
#   ADMIN_EMAIL (default: admin@local.test)

DB_USER="${DB_USER:-nr_csr}"
DB_NAME="${DB_NAME:-nr_csr}"
ADMIN_USERNAME="${ADMIN_USERNAME:-admin}"
ADMIN_EMAIL="${ADMIN_EMAIL:-admin@local.test}"
ADMIN_PASSWORD_HASH="${ADMIN_PASSWORD_HASH:-}"

if [ -z "$ADMIN_PASSWORD_HASH" ]; then
  echo "ERROR: ADMIN_PASSWORD_HASH is required (bcrypt hash)."
  echo "Example: export ADMIN_PASSWORD_HASH='\$2y\$10\$...'"
  exit 1
fi

echo "Creating admin user in PostgreSQL database..."

psql -v ON_ERROR_STOP=1 -U "$DB_USER" -d "$DB_NAME" <<SQL
DELETE FROM nr_csr.tbl_user WHERE username = '${ADMIN_USERNAME}';

INSERT INTO nr_csr.tbl_user (
    id_user,
    username,
    email,
    nama,
    jabatan,
    password,
    role,
    status
) VALUES (
    100001,
    '${ADMIN_USERNAME}',
    '${ADMIN_EMAIL}',
    'Administrator',
    'System Administrator',
    '${ADMIN_PASSWORD_HASH}',
    'Admin',
    'Active'
);

SELECT id_user, username, email, nama, role, status
FROM nr_csr.tbl_user
WHERE username = '${ADMIN_USERNAME}';
SQL

echo "Admin user created/updated successfully for username: ${ADMIN_USERNAME}"
