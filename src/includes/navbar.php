<nav>
    <div class="nav-wrapper">
        <b><a href="<?=BASE_URL . "/index.php"?>" class="brand-logo">Job board</a></b>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="/offers">Offers</a></li>
            <?php if (isset($_SESSION['user'])) echo '<li><a href="/applications">Applications</a></li>'; ?>
            <li><a href="/users">Profile</a></li>
        </ul>
    </div>
</nav>