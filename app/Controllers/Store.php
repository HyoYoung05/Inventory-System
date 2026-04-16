<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\CartItemModel;
use App\Models\ProductModel;

class Store extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $search = trim((string) $this->request->getGet('search'));
        $selectedCategory = trim((string) $this->request->getGet('category'));
        $selectedPriceRange = trim((string) $this->request->getGet('price_range'));
        $currentPage = max(1, (int) $this->request->getGet('page'));
        $perPage = 15;
        $role = (string) session()->get('role');
        $cartCount = 0;
        $products = $productModel->getProductsWithCategory($search);
        $categories = $categoryModel->orderBy('name', 'ASC')->findAll();
        $categoryCards = [];

        foreach ($categories as $category) {
            $categoryName = (string) ($category['name'] ?? '');
            $categoryProducts = array_values(array_filter(
                $products,
                static fn (array $product): bool => strcasecmp((string) ($product['category_name'] ?? ''), $categoryName) === 0
            ));

            $categoryCards[] = [
                'id' => (int) ($category['id'] ?? 0),
                'name' => $categoryName,
                'description' => (string) ($category['description'] ?? ''),
                'product_count' => count($categoryProducts),
                'image_path' => $categoryProducts[0]['image_path'] ?? null,
            ];
        }

        if ($selectedCategory !== '') {
            $products = array_values(array_filter(
                $products,
                static fn (array $product): bool => strcasecmp((string) ($product['category_name'] ?? ''), $selectedCategory) === 0
            ));
        }

        if ($selectedPriceRange !== '') {
            $products = array_values(array_filter(
                $products,
                static function (array $product) use ($selectedPriceRange): bool {
                    $price = (float) ($product['price'] ?? 0);

                    return match ($selectedPriceRange) {
                        'under_500' => $price < 500,
                        '500_1000' => $price >= 500 && $price <= 1000,
                        '1000_5000' => $price > 1000 && $price <= 5000,
                        'above_5000' => $price > 5000,
                        default => true,
                    };
                }
            ));
        }

        $totalProducts = count($products);
        $totalPages = max(1, (int) ceil($totalProducts / $perPage));
        $currentPage = min($currentPage, $totalPages);
        $products = array_slice($products, ($currentPage - 1) * $perPage, $perPage);

        if ((bool) session()->get('isLoggedIn') && $role === 'user') {
            $cartRows = (new CartItemModel())
                ->where('user_id', session()->get('id'))
                ->findAll();

            foreach ($cartRows as $cartRow) {
                $cartCount += max(1, (int) ($cartRow['quantity'] ?? 0));
            }
        }

        $dashboardUrl = match ($role) {
            'admin' => site_url('admin/dashboard'),
            'staff' => site_url('staff/dashboard'),
            'user' => site_url('user/dashboard'),
            default => site_url('/'),
        };

        $dashboardLabel = match ($role) {
            'admin' => 'Admin Dashboard',
            'staff' => 'Staff Dashboard',
            'user' => 'Buyer Dashboard',
            default => 'Browse Store',
        };

        return view('store/index', [
            'pageTitle' => 'Store',
            'search' => $search,
            'products' => $products,
            'categories' => $categories,
            'categoryCards' => $categoryCards,
            'selectedCategory' => $selectedCategory,
            'selectedPriceRange' => $selectedPriceRange,
            'isLoggedIn' => (bool) session()->get('isLoggedIn'),
            'role' => $role,
            'username' => (string) session()->get('username'),
            'cartCount' => $cartCount,
            'dashboardUrl' => $dashboardUrl,
            'dashboardLabel' => $dashboardLabel,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }
}
