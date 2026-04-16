<?= $this->extend('layouts/inventory') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <style>
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
        }
        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: #132238;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 24px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .form-control, .form-select {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
            width: 100%;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            background: #fff;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }
        .btn-submit {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .btn-cancel {
            flex: 1;
            background: #f0f0f0;
            color: #333;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background: #e0e0e0;
        }
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        .alert-danger {
            background: #ffebee;
            color: #c62828;
        }
        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }
        .alert-danger li {
            margin-bottom: 5px;
        }
    </style>
    <div class="form-card">
        <h1 class="form-title"><i class="bi bi-plus-lg"></i> Add New Product</h1>
        
        <?php if (session()->get('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->get('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('products/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="name"><i class="bi bi-bag"></i> Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" placeholder="Enter product name" required>
            </div>
            <div class="form-group">
                <label for="description"><i class="bi bi-card-text"></i> Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter product description"><?= old('description') ?></textarea>
            </div>
            <div class="form-group">
                <label for="price"><i class="bi bi-currency-dollar"></i> Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= old('price') ?>" placeholder="0.00" required>
            </div>
            <div class="form-group">
                <label for="stock"><i class="bi bi-stack"></i> Stock Quantity</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock') ?>" placeholder="0" required>
            </div>
            <div class="form-group">
                <label for="category_id"><i class="bi bi-folder"></i> Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="supplier_id"><i class="bi bi-truck"></i> Supplier</label>
                <select class="form-select" id="supplier_id" name="supplier_id" required>
                    <option value="">Select a supplier</option>
                    <?php foreach ($suppliers as $supplier): ?>
                        <option value="<?= $supplier['id'] ?>" <?= old('supplier_id') == $supplier['id'] ? 'selected' : '' ?>><?= $supplier['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="bi bi-check-lg"></i> Add Product</button>
                <a href="<?= base_url('products') ?>" class="btn-cancel"><i class="bi bi-x-lg"></i> Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>