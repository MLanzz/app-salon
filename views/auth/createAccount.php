<h1 class="name-page">Crear cuenta</h1>

<p class="desc-page">Llena el siguiente formulario para crear una cuenta</p>

<form action="/createAccount" class="form" method="POST">
    <div class="field">
        <label for="firstName">Nombre</label>
        <input 
            type="text"
            id="firstName"
            name="firstName"
            placeholder="Tu nombre"
            required
        />
    </div>

    <div class="field">
        <label for="lastName">Apellido</label>
        <input 
            type="text"
            id="lastName"
            name="lastName"
            placeholder="Tu apellido"
            required
        />
    </div>

    <div class="field">
        <label for="phone">Teléfono</label>
        <input 
            type="tel"
            id="phone"
            name="phone"
            placeholder="Tu teléfono"
            required
        />
    </div>

    <div class="field">
        <label for="email">E-Mail</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-mail"
            required
        />
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input 
            type="tel"
            id="password"
            name="password"
            placeholder="Tu Password"
            required
        />
    </div>

    <input type="submit" class="button-submit" value="Crear cuenta">

</form>

<div class="actions">
    <a href="/">¿Ya tienen una cuenta? Inicia sesión</a>
</div>