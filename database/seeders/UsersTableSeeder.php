<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::updateOrCreate(['name' => 'Admin']);

        $admin = [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('1230012300'),
        ];

        $user = [
            'name' => 'customer',
            'email' => 'customer@customer.com',
            'password' => bcrypt('1230012300'),
        ];

        $admin = User::create($admin);
        $user = User::create($user);

        $admin->roles()->sync($role);
    }
}
