<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Orders extends BaseController
{
    public function index()
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $orderModel = new OrderModel();
        $search = trim((string) $this->request->getGet('search'));
        $status = trim((string) $this->request->getGet('status'));

        return view('admin/orders/index', [
            'pageTitle' => 'Orders',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'search' => $search,
            'status' => $status,
            'orders' => $orderModel->getFilteredOrders($search, $status),
        ]);
    }

    public function details($id)
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $orderModel = new OrderModel();
        $order = $orderModel
            ->select('orders.*, users.username as processed_by')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->find((int) $id);

        if (!$order) {
            return redirect()->to('admin/orders')->with('error', 'Order not found');
        }

        $orderItems = [];

        try {
            $db = \Config\Database::connect();
            $orderItems = $db->table('order_items')
                ->select('order_items.quantity, order_items.price_at_time as price, order_items.subtotal, products.name as product_name, products.sku')
                ->join('products', 'products.id = order_items.product_id', 'left')
                ->where('order_items.order_id', (int) $id)
                ->get()
                ->getResultArray();
        } catch (\Exception) {
        }

        return view('admin/orders/details', [
            'pageTitle' => 'Order Details',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'order' => $order,
            'orderItems' => $orderItems,
        ]);
    }

    public function updateStatus($id)
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $orderModel = new OrderModel();
        $order = $orderModel->find((int) $id);

        if (!$order) {
            return redirect()->to('admin/orders')->with('error', 'Order not found');
        }

        $newStatus = (string) $this->request->getPost('status');
        $allowedStatuses = ['to_be_packed', 'to_be_shipped', 'to_be_delivered', 'completed', 'cancelled'];

        if (in_array($newStatus, $allowedStatuses, true) && $orderModel->update((int) $id, ['status' => $newStatus])) {
            return redirect()->back()->with('success', 'Order status updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update order status');
    }

    private function ensureAdminAccess()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('auth/login')->with('error', 'Admin access required');
        }

        return null;
    }
}
