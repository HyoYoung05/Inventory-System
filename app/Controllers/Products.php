<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Products extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login'))->with('error', 'Please login first');
        }

        return match (session()->get('role')) {
            'admin' => redirect()->to(site_url('admin/inventory')),
            'staff' => redirect()->to(site_url('staff/dashboard')),
            default => redirect()->to(site_url('user/categories')),
        };
    }

    public function create()
    {
        return redirect()->to(site_url('admin/inventory'))->with('error', 'Products are managed through the admin inventory screen.');
    }

    public function store()
    {
        return redirect()->to(site_url('admin/inventory'))->with('error', 'Products are managed through the admin inventory screen.');
    }

    public function edit($id)
    {
        return redirect()->to(site_url('admin/inventory/edit/' . (int) $id));
    }

    public function update($id)
    {
        return redirect()->to(site_url('admin/inventory/edit/' . (int) $id));
    }

    public function delete($id)
    {
        return redirect()->to(site_url('admin/inventory'))->with('error', 'Delete products from the appropriate management screen.');
    }
}
