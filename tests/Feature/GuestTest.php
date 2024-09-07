<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Tests\TestCase;

class GuestTest extends TestCase
{
    public function testGuest(){ 
        self::assertTrue(FacadesGate::allows("create", User::class));
    } 

    public function testGuestLogin(){
        $this->seed([UserSeeder::class]);
        $user = User::where("email", "adi@localhost.com")->first();
        Auth::login($user);
        
        self::assertFalse(FacadesGate::allows("create", User::class));
    } 
}