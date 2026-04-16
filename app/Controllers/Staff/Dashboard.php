<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProductModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if ($redirect = $this->ensureStaffAccess()) {
            return $redirect;
        }

        $orderModel = new OrderModel();
        $productModel = new ProductModel();

        $data = [
            'pageTitle' => 'Dashboard',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'totalOrders' => $orderModel->countAll(),
            'totalProducts' => $productModel->countAll(),
            'outOfStockCount' => $productModel->where('stock_quantity', 0)->countAllResults(),
            'lowStockProducts' => $productModel->where('stock_quantity <', 20)->orderBy('stock_quantity', 'ASC')->limit(10)->findAll(),
            'recentOrders' => $orderModel->orderBy('created_at', 'DESC')->limit(8)->findAll(),
        ];

        return view('staff/dashboard', $data);
    }

    private function ensureStaffAccess()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'staff') {
            return redirect()->to('auth/login')->with('error', 'Staff access required');
        }

        return null;
    }
}
