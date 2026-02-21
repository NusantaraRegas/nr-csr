-- SQL script to create admin user directly in PostgreSQL
-- SECURITY NOTE:
-- 1) Do not commit plaintext passwords.
-- 2) Generate a bcrypt hash externally and replace __ADMIN_PASSWORD_HASH__ below.
-- 3) Rotate the password after first login.

-- First, check if the user already exists and delete if needed.
DELETE FROM nr_csr.tbl_user WHERE username = 'admin';

-- Insert admin user with externally generated bcrypt hash placeholder.
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
    '__ADMIN_PASSWORD_HASH__',                                                         -- replace with bcrypt hash
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
