<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromArray;

class ProductExport implements FromArray
{

    public function array(): array
    {
        $list = [];
        $products = Product::all();
        foreach ($products as $product) {
            $userName = optional($product->user)->name; // Use optional() to prevent "Attempt to read property 'name' on null"
            $list[] = [$product->title, $product->description, $product->user_id, $userName];
        }
        return $list;
    }
}