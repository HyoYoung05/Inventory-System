<?= $this->extend('layouts/inventory') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <style>
        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .products-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #132238;
            margin: 0;
        }
        .btn-add-product {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-add-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .products-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .products-table table {
            margin: 0;
        }
        .products-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .products-table th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }
        .products-table td {
            border: 1px solid #f0f0f0;
            padding: 15px;
            vertical-align: middle;
        }
        .products-table tbody tr:hover {
            background: #f8f9ff;
        }
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-edit {
            background: #e3f2fd;
            color: #1976d2;
        }
        .btn-edit:hover {
            background: #1976d2;
            color: white;
        }
        .btn-delete {
            background: #ffebee;
            color: #c62828;
        }
        .btn-delete:hover {
            background: #c62828;
            color: white;
        }
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .price-badge {
            background: #f0f0f0;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            color: #667eea;
        }
        .stock-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
        }
        .stock-high {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .stock-low {
            background: #fff3e0;
            color: #e65100;
        }
    </style>
    <div class="products-header">
        <h1><i class="bi bi-box-seam"></i> Products</h1>
        <a href="<?= base_url('products/create') ?>" class="btn btn-add-product"><i class="bi bi-plus-lg"></i> Add Product</a>
    </div>
    
    <?php if (session()->get('success')): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> <?= session()->get('success') ?>
        </div>
    <?php endif; ?>
    
    <div class="products-table">
        <table class="table">
            <thead>
                <tr>
                    <th><i class="bi bi-hash"></i> ID</th>
                    <th><i class="bi bi-bag"></i> Product Name</th>
                    <th><i class="bi bi-currency-dollar"></i> Price</th>
                    <th><i class="bi bi-stack"></i> Stock</th>
                    <th><i class="bi bi-gear"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><strong>#<?= $product['id'] ?></strong></td>
                        <td><strong><?= $product['name'] ?></strong></td>
                        <td><span class="price-badge">$<?= number_format($product['price'], 2) ?></span></td>
                        <td>
                            <span class="stock-badge <?= $product['stock'] > 50 ? 'stock-high' : 'stock-low' ?>">
                                <?= $product['stock'] ?> units
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('products/edit/' . $product['id']) ?>" class="btn-edit"><i class="bi bi-pencil"></i> Edit</a>
                            <a href="<?= base_url('products/delete/' . $product['id']) ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?')"><i class="bi bi-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>