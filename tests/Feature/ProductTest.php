<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected $productService;
    protected $product;

    public function setUp():void {
        parent::setUp();
        $this->productService = $this->app->make('App\Services\ProductsService');
        $this->product=[
            "title"=>"Test Product",
            "description"=>"Test",
            "user_id"=>1,
            "size"=>30,
            "color"=>"red",
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_product_without_data()
    {
        $response = $this->post('/api/products');

        $response->assertStatus(500);
    }
    public function test_create_product_without_auth()
    {
        $response = $this->withHeaders(['Accept'=>'application/json'])
            ->post('/api/products',$this->product);

        $response->assertStatus(401);
    }
    public function test_create_product_with_auth()
    {
        $user=User::first();
        $response = $this->withHeaders(['Accept'=>'application/json'])
            ->actingAs($user)->post('/api/products');
        $response->assertStatus(406);
    }
    public function test_create_product_with_auth_success()
    {
        $user=User::first();
        $response = $this->withHeaders(['Accept'=>'application/json'])
            ->actingAs($user)->post('/api/products',$this->product);
        $response->assertStatus(200);
    }
}
