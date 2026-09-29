<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_coach_can_search_students_with_query()
    {
        $coach = User::factory()->create([
            'role' => 'coach',
            'status' => 'active',
        ]);

        $response = $this->actingAs($coach)->get(route('students.index', ['search' => 'Ferdi']));

        $response->assertStatus(200);
        $response->assertSee('<button type="submit"', false);
        $response->assertSee('Cari');
        $response->assertSee('name="search"', false);
    }
}
