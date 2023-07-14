<div class="nav-bar-desktop">

    <?php $currentUrl = $_SERVER['REQUEST_URI'] === "" ? '/' : $_SERVER['REQUEST_URI']; ?>

    <a href="/appointments" class="nav-bar-desktop-item first-item <?php echo ($currentUrl === "/appointments") ? "activePage" : ""; ?>">Citas</a>
    
    <?php if($_SESSION["admin"] === "1"): ?>
        <a href="/admin" class="nav-bar-desktop-item <?php echo ($currentUrl === "/admin") ? "activePage" : ""; ?>">Panel de administración</a>
        <a href="/services" class="nav-bar-desktop-item <?php echo ($currentUrl === "/services") ? "activePage" : ""; ?>">Servicios</a>
    <?php endif; ?>
    
    <div class="nav-bar-desktop-item user-profile-dropdown">
        <p id="user-profile"><?php echo $fullName ?? ""; ?></p>
        <div class="user-profile-dropdown-content">
            <a href="/logout" class="user-profile-dropdown-item">Cerrar sesión</a>
        </div>
    </div>
</div>

<div>

</div>

<div class="side-nav">
    <a>
        <img class="icon-menu close-menu-btn" src="build/img/close-menu-icon.svg" alt="">
    </a>
    <?php if($_SESSION["admin"] === "1"): ?>
        <a href="/admin">Citas</a>
    <?php endif; ?>
    <a href="/appointments">Sacar cita</a>
    <a href="/services">Servicios</a>
    <a href="/logout">Cerrar sesión</a>
</div>

<div class="nav-bar-mobile">
    <img class="icon-menu open-menu-btn" src="build/img/bars-solid.svg" alt="">

    <p>Hola: <?php echo $fullName ?? ""; ?></p>
</div>
