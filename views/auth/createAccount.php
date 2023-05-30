<h1 class="name-page">Crear cuenta</h1>

<p class="desc-page">Llena el siguiente formulario para crear una cuenta</p>

<?php include_once __DIR__ . "/../templates/alerts.php"; ?>

<form action="/createAccount" class="form" method="POST">
    <div class="field">
        <label for="firstName">Nombre</label>
        <input 
            type="text"
            id="firstName"
            name="firstName"
            placeholder="Tu nombre"
            value="<?php echo s($user->firstName) ?>"
        />
    </div>

    <div class="field">
        <label for="lastName">Apellido</label>
        <input 
            type="text"
            id="lastName"
            name="lastName"
            placeholder="Tu apellido"
            value="<?php echo s($user->lastName) ?>"
            
        />
    </div>

    <div class="field">
        <label for="phone">Teléfono</label>
        <input 
            type="tel"
            id="phone"
            name="phone"
            placeholder="Tu teléfono"
            value="<?php echo s($user->phone) ?>"
            
        />
    </div>

    <div class="field">
        <label for="email">E-Mail</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-mail"
            value="<?php echo s($user->email) ?>"
            
        />
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input 
            type="tel"
            id="password"
            name="password"
            placeholder="Tu Password"
            
        />
    </div>

    <input type="submit" class="button-submit" value="Crear cuenta">

</form>

<div class="actions">
    <a href="/">¿Ya tienen una cuenta? Inicia sesión</a>
</div>