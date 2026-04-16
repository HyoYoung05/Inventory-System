<?= $this->extend('layouts/staff_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <a href="<?= base_url('staff/orders') ?>" class="btn btn-sm btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Create New Order</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= base_url('staff/orders/store') ?>">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Enter customer full name" required value="<?= old('customer_name') ?>">
            </div>

            <div class="mb-3">
                <label for="total_amount" class="form-label">Total Amount <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">&#8369;</span>
                    <input type="number" name="total_amount" id="total_amount" class="form-control" placeholder="0.00" step="0.01" required value="<?= old('total_amount') ?>">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Create Order
                </button>
                <a href="<?= base_url('staff/orders') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
