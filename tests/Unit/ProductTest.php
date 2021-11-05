<?php
namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProductTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware; // use this trait
    
    public function test_can_create_product() {
        
        $data = [
            'name' => $this->faker->sentence,
            'tag' => $this->faker->words(3, true),
            'count' => $this->faker->randomNumber(3),
            'rating' => $this->faker->randomNumber(3),
            'price' => $this->faker->randomNumber(3),
            'description' => $this->faker->paragraph,
            'title' => $this->faker->sentence,
        ];
        $this->withoutExceptionHandling();
        $this->post('/api/products', $data)->assertStatus(200);
    }

    public function test_can_update_product() {
        $product = Product::factory()->create();
        $data = [
            'name' => $this->faker->sentence,
            'tag' => $this->faker->words(3, true),
            'count' => $this->faker->randomNumber(3),
            'rating' => $this->faker->randomNumber(3),
            'price' => $this->faker->randomNumber(3),
            'description' => $this->faker->paragraph,
            'title' => $this->faker->sentence,
        ];
        $this->withoutExceptionHandling();
        $this->put('/api/products/' . $product->id, $data)->assertStatus(200);
    }

    public function test_can_show_product() {
        $product = Product::factory()->create();
        $this->get('/api/products/' . $product->id)->assertStatus(200);
    }

    public function test_can_delete_product() {
        $product = Product::factory()->create();
        $this->withoutExceptionHandling();
        $this->delete('/api/products/' . $product->id)->assertStatus(200);
    }
}