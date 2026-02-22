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
        $defaultPassword = env('DEFAULT_USER_PASSWORD');

        if (empty($defaultPassword)) {
            throw new \RuntimeException('DEFAULT_USER_PASSWORD must be set before running SuperAdminSeeder.');
        }

        // Postgres local DB: we normalize to lowercase table name.
        $table = 'nr_csr.tbl_user';

        $existing = DB::table($table)
            ->whereRaw('LOWER(username) = ?', [$username])
            ->first();

        $payload = [
            'username' => $username,
            'email' => 'superadmin@local.test',
            'nama' => 'Super Admin (Local)',
            'jabatan' => 'Administrator',
            'password' => bcrypt($defaultPassword),
            // Role is used throughout controllers for authorization/redirect.
            'role' => 'Admin',
            'status' => 'Active',
            'remember_token' => null,
        ];

        if ($existing) {
            DB::table($table)
                ->whereRaw('LOWER(username) = ?', [$username])
                ->update($payload);

            return;
        }

        // ID_USER is integer in our Postgres schema.
        DB::table($table)->insert(array_merge(
            ['id_user' => 999999],
            $payload
        ));
    }
}
