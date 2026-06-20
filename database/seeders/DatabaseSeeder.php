<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Two superadmins (you + your sister) and one example staff account.
        // EDIT the names/emails/passwords below to your real values.
        //
        // updateOrCreate(match, values): finds a user by email and updates it,
        // or creates it if missing — so re-running the seeder won't duplicate.
        // Passwords are auto-hashed by the 'password' => 'hashed' cast on User.
        $accounts = [
            [
                'name'     => 'Owner (you)',
                'email'    => 'owner@waymore.test',
                'password' => 'change-me-123',
                'role'     => 'superadmin',
            ],
            [
                'name'     => 'Sister',
                'email'    => 'sister@waymore.test',
                'password' => 'change-me-123',
                'role'     => 'superadmin',
            ],
            [
                'name'     => 'Example Staff',
                'email'    => 'staff@waymore.test',
                'password' => 'change-me-123',
                'role'     => 'staff',
            ],
        ];

        foreach ($accounts as $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                $account,
            );
        }
    }
}
