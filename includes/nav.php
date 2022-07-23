<?php $User = new  \App\classes\User(); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">Food United</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">Groceries</a>
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
                    <li class="nav-item">
                        <a class="nav-link" href="/cart.php">Shopping Cart</a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout.php">Logout</a>
                </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/src/forms/vue_groceries_form.php">Vue Groceries</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>