<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>
<?php $errorMessage = session()->getFlashdata('error'); ?>

<div class="row mb-4">
    <div class="col-12">
        <a href="<?= site_url('admin/inventory') ?>" class="btn btn-sm btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Inventory
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Add Product</h4>
    </div>
    <div class="card-body">
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger">
                <?= esc($errorMessage) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (empty($categories)): ?>
            <div class="alert alert-warning mb-0">
                No categories are available yet. Create a category first before adding a product.
            </div>
        <?php else: ?>
            <form method="POST" action="<?= site_url('admin/inventory/store') ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">Select category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= (int) $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sku_preview" class="form-label">SKU</label>
                        <input type="text" id="sku_preview" class="form-control" value="<?= esc($nextSku ?? 'SKU-001') ?>" readonly>
                        <div class="form-text">Generated automatically when you save the product.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= esc(old('name')) ?>" placeholder="Enter product name" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter product description"><?= esc(old('description')) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" value="<?= esc(old('price')) ?>" placeholder="0.00" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="stock_quantity" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" min="0" step="1" value="<?= esc(old('stock_quantity')) ?>" placeholder="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="product_image" class="form-label">Product Image or File</label>
                    <input type="file" name="product_image" id="product_image" class="form-control">
                    <div class="form-text">If Cloudinary is configured, uploads will go there automatically. Buyer pages will reflect this product after saving.</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Save Product
                    </button>
                    <a href="<?= site_url('admin/inventory') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
