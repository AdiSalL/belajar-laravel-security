<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::where("email", "adi@localhost.com")->first();

        Todo::create([
            "title" => "Test Todo",
            "description" => "Test Todo Description",
            "user_id" => $user->id,
        ]);
    }
}
