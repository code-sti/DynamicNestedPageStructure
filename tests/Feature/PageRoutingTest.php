<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Page;

class PageRoutingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_resolves_dynamic_routes_based_on_page_hierarchy()
    {
        $page1 = Page::factory()->create(['title' => 'Page1', 'slug' => 'page1']);
        $page2 = Page::factory()->create(['title' => 'Page2', 'slug' => 'page2', 'parent_id' => $page1->id]);
        $page3 = Page::factory()->create(['title' => 'Page3', 'slug' => 'page3', 'parent_id' => $page2->id]);
        $page4 = Page::factory()->create(['title' => 'Page4', 'slug' => 'page4', 'parent_id' => $page3->id]);

        $response = $this->get('api/page1');
        $response->assertStatus(200)->assertSee('Page1');

        $response = $this->get('api/page1/page2');
        $response->assertStatus(200)->assertSee('Page2');

        $response = $this->get('api/page1/page2/page3/page4');
        $response->assertStatus(200)->assertSee('Page4');
    }

    /** @test */
    public function it_distinguishes_pages_with_the_same_slug_based_on_their_parent()
    {
        $rootPage1 = Page::factory()->create(['title' => 'Root Page1', 'slug' => 'page1']);
        $childPage1 = Page::factory()->create(['title' => 'Child Page1', 'slug' => 'page1', 'parent_id' => $rootPage1->id]);

        $response = $this->get('api/page1');
        $response->assertStatus(200)->assertSee('Root Page1');

        $response = $this->get('api/page1/page1');
        $response->assertStatus(200)->assertSee('Child Page1');
    }
}
