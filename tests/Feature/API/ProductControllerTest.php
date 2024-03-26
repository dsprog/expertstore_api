<?php

namespace Tests\Feature\API;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_product_get_endpoint_list_all_products()
    {
        Product::factory(3)->create();

        $response = $this->getJson('/api/products');

        //$response->dd();
        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json){

            $json->hasAll(['data', 'links', 'meta']);

            $json->hasAll(['data.0.name', 'data.0.price', 'data.0.price_float']);

            $json->whereAllType([
                'data.0.name' => 'string',
                'data.0.price' => 'integer',
                'data.0.price_float' => 'double'
            ]);

            $json->count('data', 3)->etc();
        });
    }

    public function test_should_product_get_endpoint_returns_a_single_product()
    {
        Product::factory(1)->create();

        $response = $this->getJson('/api/products/4');

        //$response->dd();
        $response
        //->dump()
        ->assertStatus(200);
        $response->assertJson(function(AssertableJson $json){

            $json->has('data');

            $json->hasAll(['data.name', 'data.price', 'data.price_float']);

            $json->whereAllType([
                'data.name' => 'string',
                'data.price' => 'integer',
                'data.price_float' => 'double'
            ]);
        });
    }

    public function test_should_product_post_endpoint_throw_an_unauthorized_status()
    {
        $response = $this->postJson('/api/products', []);
        $response->assertUnauthorized();
    }

    public function test_should_product_post_endpoint_create_a_new_product()
    {

        $token = User::factory()->create();
        $token = $token->createToken('default')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];

        $product = [
            'name' => 'produto teste 1',
            'price' => 1200
        ];
        $response = $this->postJson('/api/products/', $product, $headers);
        $response->assertCreated();
    }
}
