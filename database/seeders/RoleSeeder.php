<?php
// FILE: database/seeders/RoleSeeder.php
// Jalankan: php artisan db:seed --class=RoleSeeder

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name'        => 'Owner',
                'description' => 'Full access to all features and settings.',
                'permissions' => array_keys(\App\Models\Role::PERMISSIONS), // semua akses
            ],
            [
                'name'        => 'Finance',
                'description' => 'Manages financial reports, budgeting, and transactions.',
                'permissions' => ['dashboard', 'finance_accounting', 'budgeting_report'],
            ],
            [
                'name'        => 'Receptionist',
                'description' => 'Handles guest check-in, check-out, and room management.',
                'permissions' => ['dashboard', 'room_bed', 'reservation'],
            ],
            [
                'name'        => 'Staff',
                'description' => 'Views cleaning schedules and internal articles.',
                'permissions' => ['dashboard', 'article'],
            ],
        ];

        foreach ($roles as $data) {
            Role::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}