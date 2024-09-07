<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::where("email", "adi@localhost.com")->first();

        Contact::create([
            "name" => $user->name,
            "email" => $user->email,
            "phone" => "081221829",
            "user_id" => $user->id,
        ]);
    }
}
