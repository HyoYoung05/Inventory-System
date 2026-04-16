<?= $this->extend('layouts/staff_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="bi bi-tag"></i> Categories</h3>
            <a href="<?= base_url('staff/categories/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Category
            </a>
        </div>
        <p class="text-muted">Manage product categories</p>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No categories found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><strong><?= esc($category['name']) ?></strong></td>
                            <td><?= esc(substr($category['description'] ?? '', 0, 80)) ?></td>
                            <td><?= date('M d, Y', strtotime($category['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('staff/categories/edit/' . $category['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="deleteCategory(<?= $category['id'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function deleteCategory(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        window.location.href = '<?= base_url('staff/categories/delete/') ?>' + id;
    }
}
</script>

<?= $this->endSection() ?>
