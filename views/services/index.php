<?php include_once __DIR__ . "/../templates/navBar.php" ?>

<h1 class="name-page">Servicios</h1>
<p class="desc-page">Administración de servicios</p>


<input type="button" class="button no-margin align-right" id="createService" value="Crear servicio">

<dialog>
    <fieldset>
        <div class="field">
            <label for="dialogServiceName">Nombre del servicio</label>
            <input type="text" id="dialogServiceName" name="serviceName" placeholder="Nombre del servicio">
        </div>
        <div class="field">
            <label for="dialogServicePrice">Precio del servicio</label>
            $ <input type="text" id="dialogServicePrice" name="servicePrice" placeholder="Precio del servicio">
        </div>
    </fieldset>

    <input type="button" class="button" value="Crear">
    <input type="button" id="cancel-modal" class="button-delete" value="Cancelar">
</dialog>

<ul>
    <?php foreach ($services as $service): ?>
        <li>
            <p><span>Nombre:</span> <?php echo $service->serviceName; ?></p>
            <p><span>Precio:</span> $ <?php echo $service->price; ?></p>
            <input type="button" class="button" value="Actualizar servicio" name="serviceUpdate" serviceName="<?php echo $service->serviceName; ?>" servicePrice="<?php echo $service->price; ?>">
        </li>
        <hr>
    <?php endforeach; ?>
</ul>


<?php 
    $script = "
        <script src='build/js/services.js'></script>
    "
?>