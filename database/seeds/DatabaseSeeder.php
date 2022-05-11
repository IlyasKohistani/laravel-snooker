<?php

use App\UserGroup;
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

        $this->call(GroupsSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(UsersSeeder::class);
    }
}
