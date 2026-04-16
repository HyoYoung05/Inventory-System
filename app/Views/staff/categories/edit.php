<?= $this->extend('layouts/staff_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <a href="<?= base_url('staff/categories') ?>" class="btn btn-sm btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Category</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= base_url('staff/categories/update/' . $category['id']) ?>">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter category name" required value="<?= old('name', $category['name']) ?>">
                <?php if (isset($validation) && $validation->hasError('name')): ?>
                    <div class="text-danger small mt-1"><?= $validation->getError('name') ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter category description"><?= old('description', $category['description']) ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Category
                </button>
                <a href="<?= base_url('staff/categories') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
