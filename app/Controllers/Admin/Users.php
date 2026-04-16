<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $userModel = new UserModel();
        $users = $userModel->findAll();

        usort($users, static function (array $left, array $right): int {
            $rolePriority = [
                'admin' => 0,
                'staff' => 1,
                'user' => 2,
            ];

            $leftPriority = $rolePriority[$left['role'] ?? 'user'] ?? 99;
            $rightPriority = $rolePriority[$right['role'] ?? 'user'] ?? 99;

            if ($leftPriority !== $rightPriority) {
                return $leftPriority <=> $rightPriority;
            }

            return strtotime((string) ($right['created_at'] ?? '')) <=> strtotime((string) ($left['created_at'] ?? ''));
        });

        return view('admin/users_list', [
            'pageTitle' => 'Users',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'users' => $users,
            'hierarchyAdmins' => $userModel->where('role', 'admin')->orderBy('created_at', 'ASC')->findAll(),
            'hierarchyStaff' => $userModel->where('role', 'staff')->orderBy('created_at', 'ASC')->findAll(),
            'hierarchyUsers' => $userModel->where('role', 'user')->orderBy('created_at', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        return view('admin/add_user', [
            'pageTitle' => 'Create User',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $userModel = new UserModel();
        $userId = $userModel->createUser(
            (string) $this->request->getPost('username'),
            (string) $this->request->getPost('password'),
            (string) $this->request->getPost('role')
        );

        if (!$userId) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Please correct the highlighted user details.')
                ->with('errors', $userModel->getCreateUserErrors());
        }

        return redirect()->to('admin/users')->with('success', 'User created successfully.');
    }

    private function ensureAdmin()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('login')->with('msg', 'Unauthorized access');
        }

        return null;
    }
}
