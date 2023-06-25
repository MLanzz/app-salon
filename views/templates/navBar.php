<div class="nav-bar-desktop">
    <p>Hola: <?php echo $fullName ?? ""; ?></p>
    
    <a href="/logout" class="button">Cerrar sesión</a>

</div>

<div class="side-nav">
    <a>
        <img class="icon-menu close-menu-btn" src="build/img/close-menu-icon.svg" alt="">
    </a>
    <a href="#">About</a>
    <a href="#">Services</a>
    <a href="#">Clients</a>
    <a href="#">Contact</a>
</div>

<div class="nav-bar-mobile">
    <img class="icon-menu open-menu-btn" src="build/img/bars-solid.svg" alt="">

    <p>Hola: <?php echo $fullName ?? ""; ?></p>
</div>
