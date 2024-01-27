<?php

namespace App\Http\Controllers\Api;

use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Requests\Products\CreateProductValidator;
use App\Requests\Products\ImportProductValidator;
use App\Requests\Products\UpdateProductValidator;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends BaseController
{
    public $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        return $this->productService->getProducts();
    }
    public function store(CreateProductValidator $createProductValidator)
    {
        if (!empty($createProductValidator->getErrors())) {
            return response()->json($createProductValidator->getErrors(), 406);
        }
        $response = $this->productService->createProduct($createProductValidator->request()->all());
        return $this->sendResponse($response);
    }

    public function update($id, UpdateProductValidator $updateProductValidator)
    {
        if (!empty($updateProductValidator->getErrors())) {
            return response()->json($updateProductValidator->getErrors(), 406);
        }
        $data = $updateProductValidator->request()->all();
        $data['user_id'] = Auth::user()->id;
        $response = $this->productService->updateProduct($id, $data);
        return $this->sendResponse($response);
    }
    public function destroy($id)
    {

        $this->productService->deleteProduct($id);
        return $this->sendResponse('deleted successfully');
    }
    public function export()
    {
        return Excel::download(new ProductExport(), 'export1.xlsx');
    }
    public function import(ImportProductValidator $importProductValidator)
    {
        if (!empty($importProductValidator->getErrors())) {
            return response()->json($importProductValidator->getErrors(), 406);
        }
        Excel::import(new ProductImport(), $importProductValidator->request()->file('file')->store('files'));
        return $this->sendResponse('saved');
    }
}