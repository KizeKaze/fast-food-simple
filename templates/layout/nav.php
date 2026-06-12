<?php $User = new  \App\Classes\User(); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light" id="top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/public/index.php">Food United</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/public/index.php">Home</a>
                </li>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/public/admin/add_item.php">Add Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/public/admin/types.php">Types</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/public/summary.php">Project Summary</a>
                    </li>
                <?php endif; ?>
                <?php if ($User->loggedIn()) : ?>
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <?= $_SESSION['username'] ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="/public/cart.php">Shopping Cart</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="nav-link" href="/src/forms/vue_groceries_form.php">Vue Groceries</a></li>
                            <li><a class="nav-link" href="/public/api/random_meal.php">Hungry?</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="nav-link" href="/public/logout.php">Log Out</a></li>
                        </ul>
                    </div>
                    <li>
                        <?php include __DIR__ . "/../../templates/components/login_message.php"; ?>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/public/login.php">Log In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/public/register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/public/summary.php">Project Summary</a>
                    </li>
                    <li>
                        <button type="button" class="btn btn-outline-secondary" disabled >Guest</button>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>