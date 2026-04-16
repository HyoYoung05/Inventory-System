<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    private array $createUserErrors = [];

    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'first_name',
        'last_name',
        'email',
        'username',
        'contact',
        'date_of_birth',
        'address',
        'zip_code',
        'country',
        'password_hash',
        'role',
    ];

    // Security: Automated timestamping [cite: 9]
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'id'             => 'permit_empty|is_natural_no_zero',
        'username'      => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
        'password_hash' => 'required|min_length[20]',
        'role'          => 'required|in_list[admin,staff,user]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'That email address is already in use.',
        ],
        'username' => [
            'is_unique' => 'That username is already in use.',
        ],
        'role' => [
            'in_list' => 'Role must be admin, staff, or user.',
        ],
    ];

    public function createUser(string $username, string $password, string $role = 'user', array $profile = [])
    {
        $this->createUserErrors = [];
        $username = trim($username);
        $role = strtolower(trim($role));

        if (mb_strlen($password) < 8) {
            $this->createUserErrors = [
                'password' => 'Password must be at least 8 characters long.',
            ];

            return false;
        }

        if (!$this->isUsernameAvailableForRole($username, $role)) {
            $this->createUserErrors = [
                'username' => $this->getUsernameConflictMessage($role),
            ];

            return false;
        }

        $data = [
            'username' => $username,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
        ];

        $rules = $this->validationRules;

        if ($role === 'user') {
            $profile = array_map(
                static fn ($value) => is_string($value) ? trim($value) : $value,
                $profile
            );

            $data = array_merge($data, [
                'first_name' => (string) ($profile['first_name'] ?? ''),
                'last_name' => (string) ($profile['last_name'] ?? ''),
                'email' => (string) ($profile['email'] ?? ''),
                'contact' => (string) ($profile['contact'] ?? ''),
                'date_of_birth' => (string) ($profile['date_of_birth'] ?? ''),
                'address' => (string) ($profile['address'] ?? ''),
                'zip_code' => (string) ($profile['zip_code'] ?? ''),
                'country' => (string) ($profile['country'] ?? ''),
            ]);

            $rules = array_merge($rules, [
                'first_name' => 'required|min_length[2]|max_length[100]',
                'last_name' => 'required|min_length[2]|max_length[100]',
                'email' => 'required|valid_email|max_length[255]|is_unique[users.email,id,{id}]',
                'contact' => 'required|min_length[7]|max_length[30]',
                'date_of_birth' => 'required|valid_date[Y-m-d]',
                'address' => 'required|min_length[5]|max_length[500]',
                'zip_code' => 'required|min_length[3]|max_length[20]',
                'country' => 'required|min_length[2]|max_length[100]',
            ]);
        }

        $this->setValidationRules($rules);

        $result = $this->insert($data, true);

        if ($result === false) {
            $this->createUserErrors = $this->errors();
        }

        return $result;
    }

    public function getCreateUserErrors(): array
    {
        return $this->createUserErrors;
    }

    private function isUsernameAvailableForRole(string $username, string $role): bool
    {
        $builder = $this->builder()->where('users.username', $username);

        if ($role === 'user') {
            if ($this->db->tableExists('buyer_accounts')) {
                $builder->join('buyer_accounts', 'buyer_accounts.user_id = users.id');
            } else {
                $builder->where('users.role', 'user');
            }
        } else {
            if ($this->db->tableExists('admin_staff_accounts')) {
                $builder->join('admin_staff_accounts', 'admin_staff_accounts.user_id = users.id');
            } else {
                $builder->whereIn('users.role', ['admin', 'staff']);
            }
        }

        return $builder->countAllResults() === 0;
    }

    private function getUsernameConflictMessage(string $role): string
    {
        return $role === 'user'
            ? 'That buyer username is already in use.'
            : 'That admin or staff username is already in use.';
    }
}
