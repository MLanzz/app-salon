<h1 class="name-page">Restrablecer contaseña</h1>

<p class="desc-page">Ingrese su e-mail para restablecer su contraseña</p>

<?php include_once __DIR__ . "/../templates/alerts.php"; ?>

<form action="/forgotPassword" class="form" method="post">

<div class="field">
        <label for="email">E-Mail</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-mail"
        />
    </div>

    <input type="submit" class="button" value="Enviar">


</form>

<div class="actions">
    <a href="/">¿Ya tienen una cuenta? Inicia sesión</a>
    <a href="/createAccount">¿Aún no tienes una cuenta? Crear una</a>
</div>