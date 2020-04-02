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
            'password' => bcrypt('testtest'),
        ]);

    }
}
