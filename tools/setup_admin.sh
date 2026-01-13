#!/bin/bash
# Script to create admin user inside Docker container

echo "Creating admin user in PostgreSQL database..."

psql -U nr_csr -d nr_csr << 'EOF'
-- Delete existing admin user if exists
DELETE FROM nr_csr.tbl_user WHERE username = 'admin';

-- Insert admin user with password "admin123"
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
    'admin',
    'admin@local.test',
    'Administrator',
    'System Administrator',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Admin',
    'Active'
);

-- Verify the user was created
SELECT id_user, username, email, nama, role, status 
FROM nr_csr.tbl_user 
WHERE username = 'admin';

EOF

echo "Admin user created successfully!"
echo "Login credentials:"
echo "  Username: admin"
echo "  Password: admin123"
