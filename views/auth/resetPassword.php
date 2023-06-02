<h1 class="name-page">
    Recuperar contraseña
</h1>

<p class="desc-page">
    Colocal tu nueva contraseña a continuación
</p>

<?php include_once __DIR__ . "/../templates/alerts.php"; ?>

<?php if ($invalidToken) {
    return;
} ?>
<form class="form" method="POST">
    <div class="field">
        <label for="newPassword">Nueva contraseña</label>
        <input type="password" name="password" id="newPassword" placeholder="Nueva contraseña">
    </div>

    <input type="submit" class="button-submit" value="Guardar nueva contraseña">
</form>