<?= $this->extend('layouts/inventory') ?>

<?= $this->section('content') ?>
<header class="hero-section">
    <div class="container py-5">
        <div class="row g-4 align-items-stretch">
            <div class="col-xl-7">
                <div class="hero-copy reveal-up">
                    <span class="eyebrow">Centralized stock control</span>
                        <h1><?= esc($roleLabel) ?> dashboard: visibility that feels calm, sharp, and ready for the next move.</h1>
                        <p class="lead">
                            Keep your products, purchase orders, suppliers, and warehouse priorities in one polished dashboard designed for everyday inventory work.
                        </p>

                        <div class="alert alert-success mb-4" role="alert">
                            <?= esc($dashboardNotice) ?>
                        </div>

                        <?php if (! empty($showActionButtons)): ?>
                            <div class="d-flex flex-wrap gap-3 mb-4">
                                <a href="#" class="btn btn-teal btn-lg rounded-pill px-4">Review Stock Levels</a>
                                <a href="#" class="btn btn-outline-dark btn-lg rounded-pill px-4">Generate Report</a>
                            </div>
                        <?php else: ?>
                            <div class="mb-4">
                                <span class="badge bg-secondary">Read-only access</span>
                                <p class="small mt-2">You can browse inventory summaries and reports, but management actions are limited.</p>
                            </div>
                        <?php endif; ?>
                        <?php foreach ($heroStats as $stat): ?>
                            <div class="hero-pill">
                                <strong><?= esc($stat['value']) ?></strong>
                                <span><?= esc($stat['label']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="hero-panel reveal-up">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <span class="eyebrow mb-2">Morning priority board</span>
                            <h2 class="panel-title mb-2">Today needs fast replenishment and smooth receiving.</h2>
                            <p class="panel-copy mb-0">Packaging items are moving fastest, while receiving still has room for two more inbound trucks.</p>
                        </div>
                        <span class="badge rounded-pill text-bg-light px-3 py-2">Live</span>
                    </div>

                    <div class="metric-stack">
                        <?php foreach ($heroPanelMetrics as $metric): ?>
                            <div class="metric-stack-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span><?= esc($metric['label']) ?></span>
                                    <strong><?= esc($metric['value']) ?></strong>
                                </div>
                                <div class="progress metric-progress" role="progressbar" aria-valuenow="<?= (int) $metric['progress'] ?>" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: <?= (int) $metric['progress'] ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="hero-note">
                        <i class="bi bi-stars"></i>
                        Keep low-stock alerts under 10 before the afternoon shipment cutoff.
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="dashboard-section">
    <div class="container">
        <div class="row g-4 mb-4">
            <?php foreach ($summaryCards as $card): ?>
                <div class="col-sm-6 col-xl-3">
                    <article class="metric-card metric-card-<?= esc($card['theme']) ?> reveal-up">
                        <div class="metric-icon">
                            <i class="bi <?= esc($card['icon']) ?>"></i>
                        </div>
                        <p class="metric-label"><?= esc($card['label']) ?></p>
                        <div class="d-flex justify-content-between align-items-end gap-2 mb-2">
                            <h2 class="metric-value"><?= esc($card['value']) ?></h2>
                            <span class="metric-trend"><?= esc($card['trend']) ?></span>
                        </div>
                        <p class="metric-copy mb-0"><?= esc($card['description']) ?></p>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row g-4">
            <div class="col-xl-8">
                <section class="panel-card reveal-up">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div>
                            <span class="eyebrow mb-2">Inventory snapshot</span>
                            <h2 class="panel-title mb-2">Products that deserve attention right now.</h2>
                            <p class="panel-copy mb-0">Use this view to quickly see stock level, reorder point, location, and overall health.</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="soft-chip"><i class="bi bi-clock-history"></i> Refreshed <?= esc($updatedAt) ?></span>
                            <a href="#" class="btn btn-outline-dark rounded-pill px-3">Export CSV</a>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-7">
                            <label class="search-shell" for="inventorySearch">
                                <i class="bi bi-search"></i>
                                <input id="inventorySearch" type="search" class="form-control" placeholder="Search by product, SKU, or category">
                            </label>
                        </div>
                        <div class="col-md-5">
                            <div class="d-flex gap-2">
                                <select class="form-select">
                                    <option selected>All locations</option>
                                    <option>Main warehouse</option>
                                    <option>Retail backroom</option>
                                    <option>Service hub</option>
                                </select>
                                <button type="button" class="btn btn-dark rounded-pill px-3">Filter</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive inventory-table">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inventoryItems as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-semibold"><?= esc($item['name']) ?></div>
                                            <div class="small text-body-secondary"><?= esc($item['sku']) ?></div>
                                        </td>
                                        <td><?= esc($item['category']) ?></td>
                                        <td><?= esc($item['location']) ?></td>
                                        <td>
                                            <div class="fw-semibold"><?= esc((string) $item['stock']) ?> units</div>
                                            <div class="small text-body-secondary">Reorder at <?= esc((string) $item['reorder']) ?></div>
                                            <div class="progress stock-progress mt-2" role="progressbar" aria-valuenow="<?= (int) $item['stockPercent'] ?>" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar progress-bar-<?= esc($item['statusTone']) ?>" style="width: <?= (int) $item['stockPercent'] ?>%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?= esc($item['statusTone']) ?>">
                                                <?= esc($item['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <div class="col-xl-4">
                <section class="panel-card panel-card-dark reveal-up mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="eyebrow eyebrow-light mb-2">Restock watchlist</span>
                            <h2 class="panel-title mb-2">Where supply attention should go next.</h2>
                        </div>
                        <i class="bi bi-bell fs-4"></i>
                    </div>

                    <div class="restock-list">
                        <?php foreach ($restockWatchlist as $item): ?>
                            <article class="restock-item">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                    <div>
                                        <h3 class="restock-title"><?= esc($item['name']) ?></h3>
                                        <p class="restock-copy mb-0"><?= esc($item['detail']) ?></p>
                                    </div>
                                    <span class="status-badge status-<?= esc($item['tone']) ?>">
                                        <?= esc($item['eta']) ?>
                                    </span>
                                </div>
                                <div class="progress metric-progress mt-3" role="progressbar" aria-valuenow="<?= (int) $item['progress'] ?>" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-<?= esc($item['tone']) ?>" style="width: <?= (int) $item['progress'] ?>%"></div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section class="panel-card reveal-up">
                    <span class="eyebrow mb-2">Warehouse spread</span>
                    <h2 class="panel-title mb-2">Stock by location</h2>
                    <p class="panel-copy">A quick read on where inventory is currently sitting.</p>

                    <div class="warehouse-list mt-4">
                        <?php foreach ($warehouseDistribution as $warehouse): ?>
                            <div class="warehouse-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h3 class="warehouse-name"><?= esc($warehouse['name']) ?></h3>
                                        <p class="warehouse-copy mb-0"><?= esc($warehouse['items']) ?></p>
                                    </div>
                                    <strong><?= esc((string) $warehouse['share']) ?>%</strong>
                                </div>
                                <div class="progress stock-progress" role="progressbar" aria-valuenow="<?= (int) $warehouse['share'] ?>" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: <?= (int) $warehouse['share'] ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-lg-7">
                <section class="panel-card reveal-up h-100">
                    <span class="eyebrow mb-2">Recent activity</span>
                    <h2 class="panel-title mb-2">What changed across inventory operations.</h2>
                    <p class="panel-copy">A simple timeline for incoming stock, approvals, and transfers.</p>

                    <div class="activity-list mt-4">
                        <?php foreach ($recentActivity as $activity): ?>
                            <article class="activity-item">
                                <div class="activity-dot"></div>
                                <div>
                                    <div class="d-flex flex-wrap justify-content-between gap-2 mb-1">
                                        <h3 class="activity-title"><?= esc($activity['title']) ?></h3>
                                        <span class="activity-time"><?= esc($activity['time']) ?></span>
                                    </div>
                                    <p class="activity-copy mb-0"><?= esc($activity['detail']) ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>

            <div class="col-lg-5">
                <section class="panel-card feature-card reveal-up h-100">
                    <span class="eyebrow mb-2">Team focus</span>
                    <h2 class="panel-title mb-2">Small actions that keep the floor running smoothly.</h2>
                    <p class="panel-copy">Use this space as a front-end starting point for tasks, reminders, and team coordination.</p>

                    <div class="focus-list mt-4">
                        <?php foreach ($focusAreas as $focus): ?>
                            <article class="focus-item">
                                <div class="focus-check">
                                    <i class="bi bi-check2"></i>
                                </div>
                                <div>
                                    <h3 class="focus-title"><?= esc($focus['title']) ?></h3>
                                    <p class="focus-copy mb-0"><?= esc($focus['detail']) ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="cta-band mt-4">
                        <strong>Next best step:</strong>
                        Connect this layout to your real product, category, and supplier tables so the dashboard becomes fully live.
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
