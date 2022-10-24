<?php $User = new  \App\Classes\User(); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light" id="top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">Food United</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">Home</a>
                </li>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/add_item.php">Add Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/types.php">Types</a>
                    </li>
                <?php endif; ?>
                <?php if ($User->loggedIn()) : ?>
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <?= $_SESSION['username'] ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="/cart.php">Shopping Cart</a></li>
                            <li><hr class="dropdown-divider"></hr></li>
                            <li><a class="nav-link" href="/src/forms/vue_groceries_form.php">Vue Groceries</a></li>
                            <li><a class="nav-link" href="/random_meal.php">Hungry?</a></li>
                            <li><hr class="dropdown-divider"></hr></li>
                            <li><a class="nav-link" href="/logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <li>
                        <?php include "includes/login_message.php"; ?>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register.php">Register</a>
                    </li>
                    <li>
                        <button type="button" class="btn btn-outline-secondary" disabled >Guest</button>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>