<h1 class="name-page">Crea una cita</h1>
<p class="desc-page">Completa los datos para solicitar una cita</p>

<div id="app">

    <nav class="tabs">
        <button class="active" data-step="1">Servicios</button>
        <button data-step="2">Información cita</button>
        <button data-step="3">Resumen</button>
    </nav>

    <div class="step-1 section">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>

        <div id="services" class="services-list">

        </div>
    </div>

    <div class="step-2 section">
        <h2>Tus datos</h2>
        <p class="text-center">Ingresa tus datos y fecha de la cita</p>

        <form class="form">
            <div class="field">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" placeholder="Tu nombre" value="<?php echo $fullName ?>" readonly>
            </div>

            <div class="field">
                <label for="date">Fecha</label>
                <input type="date" name="appointmentDate" id="appointmentDate">
            </div>

            <div class="field">
                <label for="appointmentTime">Hora</label>
                <input type="time" name="appointmentTime" id="appointmentTime">
            </div>
        </form>
    </div>

    <div class="step-3 section">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>

    <div class="pagination">
        <button id="previous" class="button">&laquo; Anterior</button>
        <button id="next" class="button">Siguiente &raquo;</button>
    </div>
</div>

<?php 
$script = "<script src='build/js/app.js'></script>";
?>