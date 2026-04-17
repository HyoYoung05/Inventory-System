<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3><i class="bi bi-tag"></i> Categories</h3>
                <p class="text-muted mb-0">Add and review product categories.</p>
            </div>
            <a href="<?= site_url('admin/categories/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Category
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Created At</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">No categories found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><strong><?= esc($category['name']) ?></strong></td>
                            <td><?= date('M d, Y', strtotime($category['created_at'])) ?></td>
                            <td class="text-end">
                                <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                                    <a href="<?= site_url('admin/categories/edit/' . $category['id']) ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form method="POST" action="<?= site_url('admin/categories/delete/' . $category['id']) ?>" onsubmit="return confirm('Delete this category? This action cannot be undone.');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>


