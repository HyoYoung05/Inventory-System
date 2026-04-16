<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function index()
    {
        // Redirect to dashboard if already logged in
        if (session()->get('isLoggedIn')) {
            return $this->redirectUser(session()->get('role'));
        }
        return view('auth/login');
    }

    public function authenticate()
    {
        $session = session();
        $model = new UserModel();
        
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            // Check password using hashing 
            if (password_verify($password, $user['password_hash'])) {
                $sessionData = [
                    'id'         => $user['id'],
                    'username'   => $user['username'],
                    'role'       => $user['role'],
                    'isLoggedIn' => true,
                ];
                $session->set($sessionData);
                
                return $this->redirectUser($user['role']);
            } else {
                $session->setFlashdata('msg', 'Invalid Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username not found');
            return redirect()->to('/login');
        }
    }

    private function redirectUser($role)
    {
        // Role-based redirection - SWAPPED
        if ($role == 'admin') {
            return redirect()->to('/staff/dashboard');
        } elseif ($role == 'staff') {
            return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->to('/user/dashboard');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}