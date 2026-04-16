<div class="container mt-4">
    <h2>Create New Order</h2>
    <form action="/staff/orders/store" method="post">
        <?= csrf_field() ?> <div class="mb-3">
            <label>Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>

        <div id="product-list">
            <div class="row mb-2">
                <div class="col-md-8">
                    <label>Select Product</label>
                    <select name="products[]" class="form-select">
                        <?php foreach ($available_products as $ap): ?>
                            <option value="<?= $ap['id'] ?>"><?= $ap['name'] ?> (Stock: <?= $ap['stock_quantity'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Quantity</label>
                    <input type="number" name="qty[]" class="form-control" min="1" required>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-success mt-3">Submit Order</button>
    </form>
</div>