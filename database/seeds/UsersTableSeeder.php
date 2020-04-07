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
            'name' => 'Alexey',
            'email' => 'alexey@gmail.com',
        ], [
            'password' => bcrypt('1111qwer'),
        ]);

        User::updateOrCreate([
            'name' => 'test',
            'email' => 'test@gmail.com',
        ], [
            'password' => bcrypt('qwerqwer'),
        ]);

    }
}
