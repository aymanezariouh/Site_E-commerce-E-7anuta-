<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed roles, permissions, and basic role assignments.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'products.manage',
            'products.create',
            'products.update',
            'products.delete',
            'orders.view',
            'orders.manage',
            'reviews.moderate',
            'users.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $buyer = Role::firstOrCreate(['name' => 'buyer']);
        $seller = Role::firstOrCreate(['name' => 'seller']);
        $moderator = Role::firstOrCreate(['name' => 'moderator']);
        $admin = Role::firstOrCreate(['name' => 'admin']);

        $buyer->syncPermissions(['orders.view']);
        $seller->syncPermissions(['products.manage', 'products.create', 'products.update', 'products.delete', 'orders.view']);
        $moderator->syncPermissions(['reviews.moderate', 'orders.view']);
        $admin->syncPermissions(Permission::all());

        // Assign buyer role to users without any roles to avoid 403 on dashboard
        User::all()->each(function (User $user) use ($buyer): void {
            if ($user->roles()->count() === 0) {
                $user->assignRole($buyer);
            }
        });

        // Demo users (except admin)
        $demoUsers = [
            ['name' => 'Buyer User', 'email' => 'buyer@example.com', 'role' => 'buyer'],
            ['name' => 'Seller User', 'email' => 'seller@example.com', 'role' => 'seller'],
            ['name' => 'Moderator User', 'email' => 'moderator@example.com', 'role' => 'moderator'],
        ];

        foreach ($demoUsers as $demo) {
            $user = User::firstOrCreate(
                ['email' => $demo['email']],
                ['name' => $demo['name'], 'password' => Hash::make('password'), 'role' => $demo['role']]
            );
            $user->syncRoles([$demo['role']]);
        }
    }
}