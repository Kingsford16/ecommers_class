
<?php
require_once __DIR__ . '/../../controllers/ProductController.php';

// Retrieve categories and brands through the controller.
$controller = new ProductController();
$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();
?>

<aside class="shop-sidebar">

    <!-- Sidebar heading -->
    <div class="sidebar-heading">
        <h2>ShopPN</h2>
        <p>Find what you need</p>
    </div>

    <!-- Categories section -->
    <section class="sidebar-section">

        <h3>
            <span class="sidebar-icon">▦</span>
            Categories
        </h3>

        <?php if (empty($categories)): ?>

            <p class="sidebar-empty">No categories available.</p>

        <?php else: ?>

            <ul class="sidebar-list">

                <?php foreach ($categories as $category): ?>

                    <li>
                        <a href="/ecommers_class/shoppn/index.php?cat=<?= (int) $category['cat_id'] ?>">
                            <span><?= htmlspecialchars($category['cat_name']) ?></span>
                            <span class="sidebar-arrow">&rsaquo;</span>
                        </a>
                    </li>

                <?php endforeach; ?>

            </ul>

        <?php endif; ?>

    </section>

    <!-- Brands section -->
    <section class="sidebar-section">

        <h3>
            <span class="sidebar-icon">◇</span>
            Popular Brands
        </h3>

        <?php if (empty($brands)): ?>

            <p class="sidebar-empty">No brands available.</p>

        <?php else: ?>

            <ul class="sidebar-list">

                <?php foreach ($brands as $brand): ?>

                    <li>
                        <a href="/ecommers_class/shoppn/index.php?brand=<?= (int) $brand['brand_id'] ?>">
                            <span><?= htmlspecialchars($brand['brand_name']) ?></span>
                            <span class="sidebar-arrow">&rsaquo;</span>
                        </a>
                    </li>

                <?php endforeach; ?>

            </ul>

        <?php endif; ?>

    </section>

    <!-- Reset filters -->
    <div class="sidebar-footer">

        <a href="/ecommers_class/shoppn/index.php" class="sidebar-reset">
            View All Products
        </a>

    </div>

</aside>

