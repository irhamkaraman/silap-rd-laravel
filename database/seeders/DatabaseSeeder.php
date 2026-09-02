<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Admin User ──────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@silap.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // ── Master Data ─────────────────────────────────────────
        $this->call([
            CategorySeeder::class,
            AgencySeeder::class,
        ]);
    }
}
