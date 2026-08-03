<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class MonkeyTest extends TestCase
{
    use WithFaker;

    /**
     * Test accessing protected routes without login (Guest).
     */
    public function test_monkey_accessing_protected_routes_gets_redirected()
    {
        // Monkey mencoba masuk ke halaman profile langsung
        $response = $this->get('/profile');
        
        // Sistem harusnya mengusir (redirect) monkey ke halaman login (302)
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test submitting garbage data to login.
     */
    public function test_monkey_submitting_garbage_to_login_fails()
    {
        // Monkey mengetik asal di form login
        $response = $this->post('/login', [
            'email' => 'monyet123!!@@!!', // Bukan email valid
            'password' => 'asdfghjkl'
        ]);

        // Sistem harusnya mengembalikan error validasi untuk email
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test submitting random extremely long string to profile update.
     */
    public function test_gorilla_submitting_massive_data_to_profile_update()
    {
        // Kita butuh user login dulu
        $user = User::factory()->create();

        // Gorilla mengetik nama sebanyak 1000 karakter
        $massiveString = str_repeat('A', 1000);

        $response = $this->actingAs($user)->put('/profile', [
            'name' => $massiveString,
            'email' => 'email_beneran@gmail.com'
        ]);

        // Sistem harus menolak karena max:255
        $response->assertSessionHasErrors(['name']);
    }
}
