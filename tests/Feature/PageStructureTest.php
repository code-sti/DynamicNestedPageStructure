<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Page;

class PageStructureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_nested_page_structure()
    {
        // Create root-level pages
        $page1 = Page::factory()->create(['title' => 'Page1', 'slug' => 'page1']);
        $page5 = Page::factory()->create(['title' => 'Page5', 'slug' => 'page5']);

        // Create nested pages under Page1
        $page2 = Page::factory()->create(['title' => 'Page2', 'slug' => 'page2', 'parent_id' => $page1->id]);
        $page1Child = Page::factory()->create(['title' => 'Page1', 'slug' => 'page1', 'parent_id' => $page2->id]);
        $page3 = Page::factory()->create(['title' => 'Page3', 'slug' => 'page3', 'parent_id' => $page2->id]);
        $page4 = Page::factory()->create(['title' => 'Page4', 'slug' => 'page4', 'parent_id' => $page3->id]);
        $page5Child = Page::factory()->create(['title' => 'Page5', 'slug' => 'page5', 'parent_id' => $page3->id]);

        // Assertions to verify database content
        $this->assertDatabaseHas('pages', ['title' => 'Page1', 'parent_id' => null]);
        $this->assertDatabaseHas('pages', ['title' => 'Page2', 'parent_id' => $page1->id]);
        $this->assertDatabaseHas('pages', ['title' => 'Page3', 'parent_id' => $page2->id]);
        $this->assertDatabaseHas('pages', ['title' => 'Page4', 'parent_id' => $page3->id]);
        $this->assertDatabaseHas('pages', ['title' => 'Page5', 'parent_id' => $page3->id]);

        // Test nested route resolution
        $response = $this->getJson('/api/page1/page2/page1');
        $response->assertStatus(200)
            ->assertJson([
                'id' => $page1Child->id,
                'title' => 'Page1',
                'slug' => 'page1',
                'parent_id' => $page2->id,
            ]);

        $response = $this->getJson('/api/page1/page2/page3/page4');
        $response->assertStatus(200)
            ->assertJson([
                'id' => $page4->id,
                'title' => 'Page4',
                'slug' => 'page4',
                'parent_id' => $page3->id,
            ]);

        $response = $this->getJson('/api/page1/page3/page5');
        $response->assertStatus(200)
            ->assertJson([
                'id' => $page5Child->id,
                'title' => 'Page5',
                'slug' => 'page5',
                'parent_id' => $page3->id,
            ]);
    }
}
