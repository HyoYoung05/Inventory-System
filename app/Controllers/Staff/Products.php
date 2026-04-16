<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class Products extends BaseController
{
    public function index()
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $search = trim((string) $this->request->getGet('search'));

        $data = [
            'pageTitle' => 'Products (Inventory)',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'search' => $search,
            'products' => $productModel->getProductsWithCategory($search),
        ];

        return view('staff/products/index', $data);
    }

    public function create()
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data = [
            'pageTitle' => 'Add Product',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'nextSku' => $productModel->getNextSku(),
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('staff/products/create', $data);
    }

    public function store()
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $productModel = new ProductModel();

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'name' => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ];

        for ($attempt = 0; $attempt < 3; $attempt++) {
            $data['sku'] = $productModel->getNextSku();

            if ($productModel->insert($data) !== false) {
                return redirect()->to('staff/products')->with('success', 'Product added successfully');
            }

            $errors = $productModel->errors();
            if (!isset($errors['sku'])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Please correct the highlighted product details.')
                    ->with('errors', $errors);
            }
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Unable to generate a unique SKU right now. Please try again.')
            ->with('errors', ['sku' => 'The system could not generate a unique SKU.']);
    }

    public function details($id)
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->to('staff/products')->with('error', 'Product not found');
        }

        $data = [
            'pageTitle' => 'Product Details',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'product' => $product,
        ];

        return view('staff/products/details', $data);
    }

    private function ensureAdminAccess()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('auth/login')->with('error', 'Admin access required');
        }

        return null;
    }
}
