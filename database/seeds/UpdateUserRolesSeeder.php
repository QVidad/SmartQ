<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->where('email', 'admin@gmail.com')->update([
            'role_id' => 3,
            'updated_at' => now(),
        ]);
    }
}
