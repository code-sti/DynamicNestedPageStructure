<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Page;

class PageCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_page()
    {
        $response = $this->postJson('/api/pages', [
            'title' => 'New Page',
            'slug' => 'new-page',
            'content' => 'Page content',
            'parent_id' => null,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('pages', ['title' => 'New Page']);
    }

    /** @test */
    public function it_can_update_a_page()
    {
        $page = Page::factory()->create([
            'title' => 'Original Title',
            'slug' => 'original-slug',
            'content' => 'Original content',
        ]);

        // Update the page with all required fields
        $response = $this->putJson("/api/pages/{$page->id}", [
            'title' => 'Updated Title',
            'slug' => 'updated-slug',  // Include slug
            'content' => 'Updated content',  // Include content
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('pages', ['title' => 'Updated Title']);
    }

    /** @test */
    public function it_can_delete_a_page()
    {
        $page = Page::factory()->create();

        $response = $this->deleteJson("/api/pages/{$page->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    /** @test */
    public function it_shows_validation_errors_when_creating_a_page_with_invalid_data()
    {
        $response = $this->postJson('/api/pages', [
            'slug' => 'invalid slug!',  // Invalid slug
            // Don't provide other required fields, such as title and content
        ]);

        $response->assertStatus(422);  // Check for validation error status code
        $response->assertJsonValidationErrors(['title', 'content']);  // Validate errors for title and content
    }
}
