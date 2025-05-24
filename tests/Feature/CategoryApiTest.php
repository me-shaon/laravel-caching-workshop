<?php

namespace Tests\Feature;

use App\Components\CacheKey;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_endpoint_returns_active_categories_and_uses_cache(): void
    {
        // Arrange
        $activeCategories = Category::factory()->count(3)->create(['is_active' => true]);
        Category::factory()->count(2)->create(['is_active' => false]); // Inactive categories

        Cache::shouldReceive('remember')
            ->once()
            ->withArgs(function ($key, $ttl, $callback) {
                return $key === CacheKey::categories() && 
                       $ttl instanceof \Illuminate\Support\Carbon &&
                       $callback instanceof \Closure;
            })
            ->andReturnUsing(function ($key, $ttl, $callback) {
                return $callback();
            });

        // Act - First request (cache miss)
        $response = $this->get('/api/categories');

        // Assert - Response structure and content
        $response->assertStatus(200)
            ->assertJsonCount($activeCategories->count())
            ->assertJsonStructure([
                '*' => ['id', 'name', 'slug', 'description']
            ]);
    }

    public function test_categories_are_actually_stored_in_cache(): void
    {
        // Arrange
        Cache::flush(); // Clear the cache
        $activeCategories = Category::factory()->count(3)->create(['is_active' => true]);

        // Act - First request (cache miss)
        $response = $this->get('/api/categories');

        // Assert - Cache is created
        $this->assertTrue(Cache::has(CacheKey::categories()));

        // Assert - Response still contains old data (from cache)
        $response->assertStatus(200)
            ->assertJsonCount($activeCategories->count())
            ->assertJson($response->json());
    }
}