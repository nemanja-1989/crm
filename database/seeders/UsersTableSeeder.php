<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        DB::table("users")->truncate();

        $advisorRole = Role::where("name", "Advisor")->first();

        $advisor_1 = User::create([
            'first_name' => 'Advisor 1',
            'last_name' => 'Advisor 1',
            'email' => 'advisor_1@example.com',
            'password' => bcrypt("advisor1")
        ]);

        $advisor_2 = User::create([
            'first_name' => 'Advisor 2',
            'last_name' => 'Advisor 2',
            'email' => 'advisor_2@example.com',
            'password' => bcrypt("advisor2")
        ]);

        $advisor_1->assignRole($advisorRole);
        $advisor_2->assignRole($advisorRole);
    }
}
