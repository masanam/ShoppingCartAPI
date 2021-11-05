<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;

class ProductControllerTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
    public function it_stores_data()
    {        
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
        ->post(route('product.store'), [
            //isi parameter sesuai kebutuhan request
            'name' => $this->faker->words(3, true),
            'cat' => $category->id,
            'quantity' => $this->faker->randomNumber(3),
            'buy_price' => $this->faker->randomNumber(6),
            'sell_price' => $this->faker->randomNumber(6),
        ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('product.index'));
    }

    /** @test */
    public function it_stores_data_but_using_invalid_key_quantity()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('product.store'), [
                'name' => $this->faker->words(3, true),
                'cat' => $category->id,
                'qty' => $this->faker->randomNumber(3),
                'buy_price' => $this->faker->randomNumber(6),
                'sell_price' => $this->faker->randomNumber(6),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('product.index'));
    }

}
