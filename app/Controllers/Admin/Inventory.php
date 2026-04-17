<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\CloudinaryUploader;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class Inventory extends BaseController
{
    public function index()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $search = trim((string) $this->request->getGet('search'));

        $data = [
            'pageTitle' => 'Inventory',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'search' => $search,
            'products' => $productModel->getProductsWithCategory($search),
        ];

        return view('admin/inventory_list', $data);
    }

    public function dashboard()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $orderModel = new OrderModel();
        $userModel = new UserModel();
        $totalRevenue = $orderModel->getRevenueTotal('completed');

        $sevenDaysSales = [];
        $sevenDaysLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $sevenDaysLabels[] = date('M d', strtotime("-$i days"));

            $sales = $orderModel->select('COALESCE(SUM(total_amount), 0) as total')
                ->where('DATE(created_at)', $date)
                ->where('status', 'completed')
                ->get()
                ->getRow();

            $sevenDaysSales[] = $sales->total ?? 0;
        }

        $sixMonthsSales = [];
        $sixMonthsLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = date('Y-m-01', strtotime("-$i months"));
            $monthEnd = date('Y-m-t', strtotime("-$i months"));
            $sixMonthsLabels[] = date('M Y', strtotime("-$i months"));

            $sales = $orderModel->select('COALESCE(SUM(total_amount), 0) as total')
                ->where('DATE(created_at) >=', $monthStart)
                ->where('DATE(created_at) <=', $monthEnd)
                ->where('status', 'completed')
                ->get()
                ->getRow();

            $sixMonthsSales[] = $sales->total ?? 0;
        }

        $data = [
            'pageTitle' => 'Dashboard',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'total_products' => $productModel->countAll(),
            'total_orders' => $orderModel->countAll(),
            'recent_orders' => $orderModel->orderBy('created_at', 'DESC')->limit(8)->findAll(),
            'low_stock_count' => $productModel
                ->where('stock_quantity >', 0)
                ->where('stock_quantity <', 20)
                ->countAllResults(),
            'out_of_stock_count' => $productModel
                ->where('stock_quantity', 0)
                ->countAllResults(),
            'total_revenue' => $totalRevenue,
            'sevenDaysSales' => json_encode($sevenDaysSales),
            'sevenDaysLabels' => json_encode($sevenDaysLabels),
            'sixMonthsSales' => json_encode($sixMonthsSales),
            'sixMonthsLabels' => json_encode($sixMonthsLabels),
            'hierarchyAdmins' => $userModel->where('role', 'admin')->orderBy('created_at', 'ASC')->findAll(),
            'hierarchyStaff' => $userModel->where('role', 'staff')->orderBy('created_at', 'ASC')->findAll(),
            'hierarchyUsers' => $userModel->where('role', 'user')->orderBy('created_at', 'ASC')->findAll(),
        ];

        return view('admin/dashboard', $data);
    }

    public function edit($id)
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $product = $productModel->find((int) $id);

        if (!$product) {
            return redirect()->to('admin/inventory')->with('error', 'Product not found.');
        }

        $data = [
            'pageTitle' => 'Edit Product',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'product' => $product,
        ];

        return view('admin/edit_product', $data);
    }

    public function createProduct()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        return view('admin/add_product', [
            'pageTitle' => 'Add Product',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'nextSku' => $productModel->getNextSku(),
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function storeProduct()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $data = [
            'category_id' => (int) $this->request->getPost('category_id'),
            'name' => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ];

        $uploadedFile = $this->request->getFile('product_image');
        if ($uploadedFile && $uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
            try {
                $cloudinaryUploader = new CloudinaryUploader();

                if ($cloudinaryUploader->isConfigured()) {
                    $data['image_path'] = $cloudinaryUploader->upload(
                        $uploadedFile->getTempName(),
                        $uploadedFile->getClientName()
                    );
                } else {
                    $uploadDirectory = FCPATH . 'uploads/products';

                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                    }

                    $storedName = $uploadedFile->getRandomName();
                    $uploadedFile->move($uploadDirectory, $storedName);
                    $data['image_path'] = 'uploads/products/' . $storedName;
                }
            } catch (\Throwable $exception) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $exception->getMessage());
            }
        }

        for ($attempt = 0; $attempt < 3; $attempt++) {
            $data['sku'] = $productModel->getNextSku();

            if ($productModel->insert($data) !== false) {
                return redirect()->to('admin/inventory')->with('success', 'Product added successfully.');
            }

            $errors = $productModel->errors();
            if (!isset($errors['sku'])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('errors', $errors)
                    ->with('error', 'Please correct the product details and try again.');
            }
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('errors', ['sku' => 'The system could not generate a unique SKU.'])
            ->with('error', 'Unable to generate a unique SKU right now. Please try again.');
    }

    public function update($id)
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $existingProduct = $productModel->find((int) $id);

        if (!$existingProduct) {
            return redirect()->to('admin/inventory')->with('error', 'Product not found.');
        }

        $stockQuantity = $this->request->getPost('stock_quantity');
        $imagePath = $existingProduct['image_path'] ?? null;
        $uploadedFile = $this->request->getFile('product_image');

        if ($uploadedFile && $uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
            try {
                $cloudinaryUploader = new CloudinaryUploader();

                if ($cloudinaryUploader->isConfigured()) {
                    $imagePath = $cloudinaryUploader->upload(
                        $uploadedFile->getTempName(),
                        $uploadedFile->getClientName()
                    );
                } else {
                    $uploadDirectory = FCPATH . 'uploads/products';

                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                    }

                    $storedName = $uploadedFile->getRandomName();
                    $uploadedFile->move($uploadDirectory, $storedName);
                    $imagePath = 'uploads/products/' . $storedName;
                }
            } catch (\Throwable $exception) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $exception->getMessage());
            }
        }

        $data = [
            'id' => (int) $id,
            'category_id' => $existingProduct['category_id'],
            'sku' => $existingProduct['sku'],
            'name' => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $stockQuantity,
            'image_path' => $imagePath,
        ];

        if (!$productModel->save($data)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Please provide valid product details.')
                ->with('errors', $productModel->errors());
        }

        return redirect()->to('admin/inventory')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $productModel = new ProductModel();
        $product = $productModel->find((int) $id);

        if (!$product) {
            return redirect()->to('admin/inventory')->with('error', 'Product not found.');
        }

        if (!$productModel->delete((int) $id)) {
            return redirect()->to('admin/inventory')->with('error', 'Unable to delete the product right now.');
        }

        return redirect()->to('admin/inventory')->with('success', 'Product deleted successfully.');
    }

    public function categories()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();

        return view('admin/categories_index', [
            'pageTitle' => 'Categories',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'categories' => $categoryModel->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function createCategory()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        return view('admin/category_create', [
            'pageTitle' => 'Add Category',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
        ]);
    }

    public function storeCategory()
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();
        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
        ];

        if (!$categoryModel->save($data)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Please provide a valid category.')
                ->with('errors', $categoryModel->errors());
        }

        return redirect()->to('admin/categories')->with('success', 'Category added successfully.');
    }

    public function editCategory($id)
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();
        $category = $categoryModel->find((int) $id);

        if (!$category) {
            return redirect()->to('admin/categories')->with('error', 'Category not found.');
        }

        return view('admin/category_edit', [
            'pageTitle' => 'Edit Category',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'category' => $category,
        ]);
    }

    public function updateCategory($id)
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();
        $category = $categoryModel->find((int) $id);

        if (!$category) {
            return redirect()->to('admin/categories')->with('error', 'Category not found.');
        }

        $data = [
            'id' => (int) $id,
            'name' => trim((string) $this->request->getPost('name')),
            'description' => $category['description'] ?? '',
        ];

        if (!$categoryModel->save($data)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Please provide a valid category name.')
                ->with('errors', $categoryModel->errors());
        }

        return redirect()->to('admin/categories')->with('success', 'Category name updated successfully.');
    }

    public function deleteCategory($id)
    {
        if ($redirect = $this->ensureAuthorized()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();
        $category = $categoryModel->find((int) $id);

        if (!$category) {
            return redirect()->to('admin/categories')->with('error', 'Category not found.');
        }

        if (!$categoryModel->delete((int) $id)) {
            return redirect()->to('admin/categories')->with('error', 'Unable to delete the category right now.');
        }

        return redirect()->to('admin/categories')->with('success', 'Category deleted successfully.');
    }

    private function ensureAuthorized()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('auth/login')->with('error', 'Admin access required');
        }

        return null;
    }
}




