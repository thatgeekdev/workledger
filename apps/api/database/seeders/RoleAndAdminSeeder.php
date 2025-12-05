<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndAdminSeeder extends Seeder
{
    public function run()
    {
        // Roles
        $super = Role::firstOrCreate(['name' => 'super-admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user  = Role::firstOrCreate(['name' => 'user']);

        // Super admin user
        if (! User::where('email', 'super@local.test')->exists()) {
            $u = User::create([
                'name' => 'Super Admin',
                'email' => 'super@local.test',
                'password' => Hash::make('password'),
                'status' => 'active'
            ]);
            $u->assignRole($super);
            $u->profile()->update([
                'full_name' => 'Super Admin',
                'phone_number' => '000'
            ]);
        }

        // Admin user
        if (! User::where('email', 'admin@local.test')->exists()) {
            $a = User::create([
                'name' => 'Admin User',
                'email' => 'admin@local.test',
                'password' => Hash::make('password'),
                'status' => 'active'
            ]);
            $a->assignRole($admin);
            $a->profile()->update(['full_name' => 'Admin User']);
        }
        // Admin user
        if (! User::where('email', 'user@local.test')->exists()) {
            $a = User::create([
                'name' => 'User',
                'email' => 'user@local.test',
                'password' => Hash::make('password'),
                'status' => 'active'
            ]);
            $a->assignRole($user);
            $a->profile()->update(['full_name' => 'Regular User']);
        }
    }
}

