<nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>index.php">PageAndPen</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse  " id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>index.php" 
                        class="nav-link <?= is_page('index.php') ? 'active' : '' ?>" 
                        aria-current="page">Home</a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>products/products.php" 
                        class="nav-link <?= is_page('products.php') ? 'active' : '' ?>" 
                        aria-current="page">Products</a>
                </li>
                <?php
                    if(is_admin()){ ?>
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>admin/dashboard.php" 
                                class="nav-link <?= is_page('dashboard.php') ? 'active' : '' ?>" 
                                aria-current="page">Admin</a>
                        </li>
                <?php } ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php
                    if(!is_authenticated()){
                        ?>
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>account/login.php"
                                class="nav-link <?= is_page('login.php')?'active':'' ?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>account/register.php" 
                                class="nav-link <?= is_page('register.php')?'active':'' ?>">Register</a>
                        </li>
                        <?php
                    }
                    else{
                        ?>
                        <li class="nav-item">
                            <p class="nav-link m-0 "><?= $user["name"] ?></p>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-gear me-2"></i> Settings
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-circle-user me-2"></i> My account</a></li>
                                <hr>
                                <li>
                                    <form method="post">
                                        <button type="submit" class=" btn dropdown-item logout " name="logout">
                                            <i class="fa-solid fa-arrow-right-from-bracket  me-2 "></i> Logout 
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                <?php }?>
            </ul>
        </div>
    </div>
</nav>
<?php
    if (isset($_POST['logout'])) {
        // session_destroy();
        logout();
        header('location: ' . $_SERVER['PHP_SELF']);
    }