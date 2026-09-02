<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (Admin::count() === 0) {
            Admin::create([
                'name' => 'Admin',
                'email' => 'admin@fugocreativegroup.com',
                'password' => bcrypt('CreateToElevate.'),
            ]);

            $this->command?->info('  Created admin user: admin@fugocreativegroup.com');
        }
    }
}
