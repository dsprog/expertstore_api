<?php

namespace Tests\Feature\API;

use App\Models\Product;
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
}
