<?php

use Illuminate\Database\Seeder;

use App\User;
use Encore\Admin\Auth\Database\{
    Administrator, Role
};

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=UsersTableSeeder
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'name' => 'Test',
            'email' => 'test@gmail.com',
        ], [
            'password' => bcrypt('11111111'),
        ]);

        $admin = Administrator::updateOrCreate([
            'username' => 'Admin',
            'name' => 'Administrator',
        ], [
            'password' => bcrypt('admin'),
        ]);

        $role = Role::where('slug', 'administrator')->first();
        if ($role) {
            $admin->roles()->attach($role->id);
        }

    }
}
