<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Allows fields for CRUD operations 
    protected $allowedFields    = [
        'user_id', 
        'customer_name', 
        'total_amount', 
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Requirement: Optimization and Relationships [cite: 22, 50]
     * Fetches orders with the name of the Staff/Admin who processed it
     */
    public function getOrdersWithUser()
    {
        return $this->select('orders.*, users.username as processed_by')
                    ->join('users', 'users.id = orders.user_id')
                    ->orderBy('orders.created_at', 'DESC')
                    ->findAll();
    }

    public function getFilteredOrders(?string $search = null, ?string $status = null): array
    {
        $builder = $this->select('orders.*, users.username as processed_by')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->orderBy('orders.created_at', 'DESC');

        if ($search !== null && $search !== '') {
            $builder->groupStart()
                ->like('orders.customer_name', $search)
                ->orLike('orders.id', $search)
                ->groupEnd();
        }

        if ($status !== null && $status !== '') {
            $builder->where('orders.status', $status);
        }

        return $builder->findAll();
    }

    public function getRevenueTotal(?string $status = 'completed'): float
    {
        $builder = $this->selectSum('total_amount', 'total');

        if ($status !== null && $status !== '') {
            $builder->where('status', $status);
        }

        $row = $builder->first();

        return (float) ($row['total'] ?? 0);
    }
}
