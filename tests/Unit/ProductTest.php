<?php

namespace Tests\Unit;


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
     * A basic unit test example.
     *
     * @return void
     */
    public function test_product_create_database()
    {
        $created_product=$this->productService->createProduct($this->product);
        $this->assertDatabaseHas('products',[
            "title"=>"Test Product",
        ]);
        $this->assertDatabaseHas('product_details',[
            "size"=>30,
        ]);
    }

    public function test_delete_product_database(){
        $this->productService->deleteProduct(1);
        $this->assertDatabaseMissing('products',[
            "title"=>"Test Product",
        ]);
        $this->assertDatabaseMissing('product_details',[
            "size"=>30,
        ]);
    }
}
