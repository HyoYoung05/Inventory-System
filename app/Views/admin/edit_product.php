<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="row mb-4">
    <div class="col-12">
        <a href="<?= site_url('admin/inventory') ?>" class="btn btn-sm btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Inventory
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Product</h4>
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

        <form method="POST" action="<?= site_url('admin/inventory/update/' . $product['id']) ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= esc(old('name', $product['name'])) ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" class="form-control" value="<?= esc($product['sku']) ?>" readonly>
                    <div class="form-text">SKU stays fixed once the product is created.</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" name="price" id="price" class="form-control" min="0" step="0.01" value="<?= esc(old('price', $product['price'])) ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="stock_quantity" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" min="0" step="1" value="<?= esc(old('stock_quantity', $product['stock_quantity'])) ?>" placeholder="0" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" placeholder="Add a short product description"><?= esc(old('description', $product['description'])) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="product_image" class="form-label">Product Image or File</label>
                <input type="file" name="product_image" id="product_image" class="form-control">
                <div class="form-text">This upload accepts any file type. If Cloudinary is configured, the file will be uploaded there first. If it is an image, it will appear in the store.</div>
                <?php if (!empty($product['image_path'])): ?>
                    <div class="mt-2">
                        <a href="<?= media_url($product['image_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-paperclip me-1"></i>View Current File
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Product
                </button>
                <a href="<?= site_url('admin/inventory') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
