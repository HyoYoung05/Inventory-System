<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Inventory extends BaseController
{
    public function index()
    {
        if ($redirect = $this->ensureStaffAccess()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $search = trim((string) $this->request->getGet('search'));

        return view('staff/inventory/index', [
            'pageTitle' => 'Inventory',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'search' => $search,
            'outOfStockCount' => $productModel->where('stock_quantity', 0)->countAllResults(),
            'products' => $productModel->getProductsWithCategory($search),
        ]);
    }

    private function ensureStaffAccess()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'staff') {
            return redirect()->to('auth/login')->with('error', 'Staff access required');
        }

        return null;
    }
}
