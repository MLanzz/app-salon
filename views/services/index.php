<?php include_once __DIR__ . "/../templates/navBar.php" ?>

<h1 class="name-page">Servicios</h1>
<p class="desc-page">Administración de servicios</p>


<input type="button" class="button no-margin align-right" value="Crear servicio">

<dialog>
    <fieldset>
        <div class="field">
            <label for="serviceName">Nombre del servicio</label>
            <input type="text" id="serviceName" name="serviceName" placeholder="Nombre del servicio">
        </div>
        <div class="field">
            <label for="servicePrice">Precio del servicio</label>
            <input type="text" id="servicePrice" name="servicePrice" placeholder="Precio del servicio">
        </div>
    </fieldset>

    <input type="button" class="button" value="Crear">
</dialog>

<ul>
    <?php foreach ($services as $service): ?>
        <li>
            <p><span>Nombre:</span> <?php echo $service->serviceName; ?></p>
            <p><span>Precio:</span> <?php echo $service->price; ?></p>
        </li>
        <hr>
    <?php endforeach; ?>
</ul>