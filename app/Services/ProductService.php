<?php

namespace App\Services;

use App\Events\newProductMail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class ProductService
{
    public function getProducts()
    {
        return Product::all();
    }
    public function getProduct(int $id)
    {
        return Product::find($id);
    }

    public function createProduct($data)
    {
        $product = Product::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => Auth::user()->id,
        ]);
        $product->details()->create($data);
        Event::dispatch(new newProductMail($product));
        return $product;
    }

    public function updateProduct($id, $data)
    {
        $product = $this->getProduct($id);
        // dd($product);
        // Update product attributes
        $product->update([

            'title' => $data['title'],
        ]);

        // Update product details
        $product->details()->update([
            'color' => $data['color'],
            'size' => $data['size'],
            // Add other attributes as needed
        ]);

        return $product;
    }

    public function deleteProduct($id)
    {
        $product = $this->getProduct($id);
        if ($product->details) {
            $product->details()->delete();
        }
        if ($product->reviews) {

            $product->reviews()->delete();
        }
        if ($product->imagable) {
            $product->imagable()->delete();
        }
        $product->delete();
    }
}
