<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    public function index()
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();
        $data = [
            'pageTitle' => 'Categories',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'categories' => $categoryModel->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('staff/categories/index', $data);
    }

    public function create()
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $data = [
            'pageTitle' => 'Add Category',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
        ];

        return view('staff/categories/create', $data);
    }

    public function store()
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if ($categoryModel->save($data)) {
            return redirect()->to('staff/categories')->with('success', 'Category added successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to add category');
    }

    public function edit($id)
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if (!$category) {
            return redirect()->to('staff/categories')->with('error', 'Category not found');
        }

        $data = [
            'pageTitle' => 'Edit Category',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'category' => $category,
        ];

        return view('staff/categories/edit', $data);
    }

    public function update($id)
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if (!$category) {
            return redirect()->to('staff/categories')->with('error', 'Category not found');
        }

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if ($categoryModel->save($data)) {
            return redirect()->to('staff/categories')->with('success', 'Category updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update category');
    }

    public function delete($id)
    {
        if ($redirect = $this->ensureAdminAccess()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();

        if ($categoryModel->delete($id)) {
            return redirect()->to('staff/categories')->with('success', 'Category deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete category');
    }

    private function ensureAdminAccess()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('auth/login')->with('error', 'Admin access required');
        }

        return null;
    }
}
