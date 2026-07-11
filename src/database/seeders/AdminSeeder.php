<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat semua role yang diperlukan
        $roles = [
            'Admin',
            'Supervisor QC',
            'Supervisor Produksi',
            'PPIC',
            'Merchandiser',
            'Gudang',
            'Akunting',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Buat Admin pertama
        $admin = User::firstOrCreate(
            ['email' => 'admin@rejecthandler.com'],
            [
                'user_id' => 'ADM-001',
                'name' => 'Administrator',
                'password' => bcrypt('admin123'),
                'role' => 'Admin',
            ]
        );

        // Assign role Admin ke user
        $admin->assignRole('Admin');
    }
}
