<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PilarSeeder::class);
        $this->call(SdgSeeder::class);

        // Local dev helper account
        $this->call(SuperAdminSeeder::class);
    }
}
