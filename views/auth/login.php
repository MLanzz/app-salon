<?php 
//Lógica para verificar si ya se esta logeado

if(isset($_SESSION["login"])) {
    header("Location: /appointments");
}

?>

<h1 class="name-page">Login</h1>
<p class="desc-page">Inicia sesión con tus datos</p>

<?php include_once __DIR__ . "../../templates/alerts.php" ?>

<form action="/" class="form" method="POST">
    <div class="field">
        <label for="email">E-Mail</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-Mail"
        />
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu password"
        />
    </div>

    <input type="submit" class="button" value="Iniciar sesión">

</form>

<div class="actions">
    <a href="/createAccount">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/forgotPassword">Olvide mi contraseña</a>
</div>