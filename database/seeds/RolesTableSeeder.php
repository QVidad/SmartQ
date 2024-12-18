<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = [
            ['role_name' => 'Facilitator', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'Student', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['role_name' => $role['role_name']],
                ['created_at' => $role['created_at'], 'updated_at' => $role['updated_at']]
            );
        }
    }
}
