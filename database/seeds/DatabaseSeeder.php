<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);

        $this->call(FaqSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(ActivitiesSeeder::class);

        $this->call(MembersSeeder::class);
    }
}
