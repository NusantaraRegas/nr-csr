<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultPassword = env('DEFAULT_USER_PASSWORD');

        if (empty($defaultPassword)) {
            throw new \RuntimeException('DEFAULT_USER_PASSWORD must be set before running UserSeeder.');
        }

        DB::table('T_USER')
            ->update(['password' => bcrypt($defaultPassword)]);
    }
}
