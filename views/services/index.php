<?php include_once __DIR__ . "/../templates/navBar.php" ?>

<h1 class="name-page">Servicios</h1>
<p class="desc-page">Administración de servicios</p>


<input type="button" class="button no-margin align-right" id="createService" value="Crear servicio">

<dialog>
    <input type="hidden" id="dialogServiceId" value="0">
    <div class="field">
        <label class="dialog-label" for="dialogServiceName">Nombre del servicio</label>
        <input type="text" id="dialogServiceName" name="serviceName" placeholder="Nombre del servicio">
    </div>
    <div class="field">
        <label class="dialog-label" for="dialogServicePrice">Precio del servicio</label>
        <input type="text" id="dialogServicePrice" name="servicePrice" placeholder="Precio del servicio">
    </div>

    <div class="buttons-container">
        <input type="button" class="button" value="Crear" id="submit-modal">
        <input type="button" id="cancel-modal" class="button-delete" value="Cancelar">
    </div>
</dialog>

<ul id="service-list">
    <?php foreach ($services as $service): ?>
        <li data-service-id="<?php echo $service->id; ?>">
            <p><span>Nombre:</span> <span class="service-desc"><?php echo $service->serviceName; ?></span></p>
            <p><span>Precio:</span> $ <span class="service-desc"><?php echo $service->price; ?></span></p>
            <div class="buttons-container">
                <input type="button" class="button" value="Actualizar servicio" name="serviceUpdate" data-id="<?php echo $service->id; ?>" data-serviceName="<?php echo $service->serviceName; ?>" data-servicePrice="<?php echo $service->price; ?>">

                <input type="button" class="button-delete" value="Eliminar servicio" name="serviceDelete" data-id="<?php echo $service->id; ?>">
            </div>
        </li>
        <hr>
    <?php endforeach; ?>
</ul>


<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/services.js'></script>
        <script src='build/js/sideNav.js'></script>
    "
?>