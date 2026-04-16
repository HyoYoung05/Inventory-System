<div class="container mt-4">
    <h2>Order History</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $o): ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= $o['customer_name'] ?></td>
                <td>$<?= number_format($o['total_amount'], 2) ?></td>
                <td><span class="badge bg-<?= $o['status'] == 'completed' ? 'success' : 'secondary' ?>"><?= $o['status'] ?></span></td>
                <td><?= $o['created_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>