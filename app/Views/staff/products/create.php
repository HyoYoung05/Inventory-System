<?= $this->extend('layouts/staff_layout') ?>

<?= $this->section('content') ?>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="row mb-4">
    <div class="col-12">
        <a href="<?= base_url('staff/products') ?>" class="btn btn-sm btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Add Product</h4>
        <a href="<?= base_url('staff/categories/create') ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-tag"></i> Add Category
        </a>
    </div>
    <div class="card-body">
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
            <form method="POST" action="<?= base_url('staff/products/store') ?>">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">Select category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= esc($category['id']) ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['category_id'])): ?>
                            <div class="text-danger small mt-1"><?= esc($errors['category_id']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sku_preview" class="form-label">SKU</label>
                        <input type="text" id="sku_preview" class="form-control" value="<?= esc($nextSku ?? 'SKU-001') ?>" readonly>
                        <div class="form-text">Generated automatically when you save the product.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" value="<?= esc(old('name')) ?>" required>
                    <?php if (isset($errors['name'])): ?>
                        <div class="text-danger small mt-1"><?= esc($errors['name']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter product description"><?= esc(old('description')) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" class="form-control" min="0" step="0.01" placeholder="0.00" value="<?= esc(old('price')) ?>" required>
                        <?php if (isset($errors['price'])): ?>
                            <div class="text-danger small mt-1"><?= esc($errors['price']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="stock_quantity" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" min="0" step="1" placeholder="0" value="<?= esc(old('stock_quantity')) ?>" required>
                        <?php if (isset($errors['stock_quantity'])): ?>
                            <div class="text-danger small mt-1"><?= esc($errors['stock_quantity']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Save Product
                    </button>
                    <a href="<?= base_url('staff/products') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
