<div class="nav-bar-desktop">
    <p><img class="user-icon" src="build/img/user-icon.svg" alt=""> <?php echo $fullName ?? ""; ?></p>
    
    <a href="/logout" class="button">Cerrar sesión</a>

</div>

<div class="side-nav">
    <a>
        <img class="icon-menu close-menu-btn" src="build/img/close-menu-icon.svg" alt="">
    </a>
    <a href="/admin">Citas</a>
    <a href="/appointments">Sacar cita</a>
    <a href="/logout">Cerrar sesión</a>
</div>

<div class="nav-bar-mobile">
    <img class="icon-menu open-menu-btn" src="build/img/bars-solid.svg" alt="">

    <p>Hola: <?php echo $fullName ?? ""; ?></p>
</div>
