<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class testGate extends TestCase
{
    public function testGate() {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::where("email", "adi@localhost.com")->first();;
        Auth::login($user);
        
        $contact = Contact::where("email", "adi@localhost.com")->first();
        $this->assertTrue(Gate::allows("get-contact", $contact));
        $this->assertTrue(Gate::allows("update-contact",$contact));
        $this->assertTrue(Gate::allows("delete-contact", $contact));

    }

    public function testGateMethod() {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::where("email", "adi@localhost.com")->first();;
        Auth::login($user);
        
        $contact = Contact::where("email", "adi@localhost.com")->first();
        $this->assertTrue(Gate::any(["get-contact", "update-contact", "delete-contact"], $contact));
        $this->assertFalse(Gate::none(["get-contact", "update-contact", "delete-contact"], $contact));
        

    }

    public function testGateNonLogin() {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::where("email", "adi@localhost.com")->first();;
        $gate = Gate::forUser($user);
        
        $contact = Contact::where("email", "adi@localhost.com")->first();
        $this->assertTrue($gate->allows("get-contact", $contact));
        $this->assertTrue($gate->allows("update-contact",$contact));
        $this->assertTrue($gate->allows("delete-contact", $contact));

    }

    public function testGateResponse() {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::where("email", "adi@localhost.com")->first();;
        Auth::login($user);
        
        $response = Gate::inspect("create-contact");
        self::assertEquals("You'are Not Admin", $response->message());
        self::assertFalse($response->allowed());
    }



}
