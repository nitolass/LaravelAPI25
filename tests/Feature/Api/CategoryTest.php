<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_v1_returns_categories_list_over_id_5()
    {
        $user = User::factory()->create();

        $category = Category::factory()->count(6)->create();

        $response = $this->actingAs($user)
            ->getJson(route('api.v1.categories.index'));

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [Arr::only($category->toArray(), ['id', 'name'])],
            ]);
    }

    public function test_api_v2_returns_categories_list()
    {
        $user = User::factory()->create();

        $category = Category::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('api.v2.categories.index'));

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [Arr::only($category->toArray(), ['id', 'name'])],
            ]);
    }

    public function test_api_v1_category_store_successful()
    {
        $category = ['name' => 'Category 7', 'description' => 'Category 7 description'];

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('api.v1.categories.store'), $category);

        $response->assertStatus(201)
            ->assertJson(['data' => Arr::only($category, ['id', 'name'])]);
    }
}
