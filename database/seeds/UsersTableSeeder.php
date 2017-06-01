<?php

use Illuminate\Database\Seeder;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Users\RoleService;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param  UserService  $users
     * @param  RoleService  $roles
     * @return void
     */
    public function run(UserService $users, RoleService $roles)
    {
        $roles->createAllRequired();

        $users->createStarterAdmin();
    }
}
