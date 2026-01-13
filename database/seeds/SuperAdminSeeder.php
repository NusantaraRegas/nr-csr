<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Create a single local superadmin account for development.
     *
     * Notes:
     * - The app login flow expects `username` to be lowercased and `status` = 'Active'.
     * - `App\Models\User` uses:
     *   - table: TBL_USER
     *   - primary key: ID_USER (string, non-incrementing)
     *
     * This seeder is idempotent: it will not create duplicates.
     */
    public function run()
    {
        $username = 'superadmin';

        // Postgres local DB: we normalize to lowercase table name.
        $table = 'NR_CSR.tbl_user';

        $exists = DB::table($table)
            ->whereRaw('LOWER(username) = ?', [$username])
            ->exists();

        if ($exists) {
            return;
        }

        // ID_USER is integer in our Postgres schema.
        DB::table($table)->insert([
            'id_user' => 999999,
            'username' => $username,
            'email' => 'superadmin@local.test',
            'nama' => 'Super Admin (Local)',
            'jabatan' => 'Administrator',
            // Default local password. Change after first login.
            'password' => bcrypt('corp.NR'),
            // Role is used throughout controllers for authorization/redirect.
            'role' => 'Admin',
            'status' => 'Active',
            'remember_token' => null,
        ]);
    }
}
