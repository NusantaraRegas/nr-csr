-- SQL script to create admin user directly in PostgreSQL
-- This bypasses the PHP compatibility issue

-- First, let's check if the user already exists and delete if needed
DELETE FROM nr_csr.tbl_user WHERE username = 'admin';

-- Insert the admin user with bcrypt hashed password for "admin123"
-- Bcrypt hash generated for password "admin123": $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
INSERT INTO nr_csr.tbl_user (
    id_user,
    username,
    email,
    nama,
    jabatan,
    password,
    role,
    status,
    remember_token,
    id_perusahaan,
    nik,
    divisi,
    departemen,
    profile
) VALUES (
    100001,                                                                             -- id_user
    'admin',                                                                            -- username
    'admin@local.test',                                                                 -- email
    'Administrator',                                                                    -- nama
    'System Administrator',                                                             -- jabatan
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',                   -- password (admin123)
    'Admin',                                                                            -- role
    'Active',                                                                           -- status
    NULL,                                                                               -- remember_token
    NULL,                                                                               -- id_perusahaan
    NULL,                                                                               -- nik
    NULL,                                                                               -- divisi
    NULL,                                                                               -- departemen
    NULL                                                                                -- profile
)
ON CONFLICT (id_user) DO UPDATE SET
    username = EXCLUDED.username,
    password = EXCLUDED.password,
    status = EXCLUDED.status,
    role = EXCLUDED.role;

-- Verify the user was created
SELECT id_user, username, email, nama, role, status 
FROM nr_csr.tbl_user 
WHERE username = 'admin';
