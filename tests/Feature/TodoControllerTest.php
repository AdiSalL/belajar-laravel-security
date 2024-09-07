<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    public function testTodo() {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        $this->post("/api/todo")
        ->assertStatus(403);

        $user = User::where("email", "adi@localhost.com")->first();
        $this->actingAs($user)->post("/api/todo")
        ->assertStatus(200)->assertJson([
            "message" => "success"
        ]);
    }

    public function testView() {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        $user = User::where("email", "adi@localhost.com")->first();
        Auth::login($user);
        
        $todos = Todo::query()->get();
        $this->view("todos", [
            "todos" => $todos
        ])->assertSeeText("Edit")
        ->assertSeeText("Delete")
        ->assertDontSeeText("No Edit")
        ->assertDontSeeText("No Delete");
    }

    public function testViewNoAccess() {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        // $user = User::where("email", "adi@localhost.com")->first();
        // Auth::login($user);
        
        $todos = Todo::query()->get();
        $this->view("todos", [
            "todos" => $todos
        ])
        ->assertSeeText("No Edit")
        ->assertSeeText("No Delete");
    }
}
