<?php 

// Alerts: array asociativo donde la clave son los tipos de alertar y el contenido de cada clave es otro array con los mensajes de alerta
// Iteramos dos veces, una por cada tipo de alerta, y otra para ver los mensajes de cada tipo

foreach ($alerts as $alertType => $alertsDesc) :
    foreach ($alertsDesc as $alert):
?>

        <div class="alert <?php echo $alertType; ?>">
            <?php echo $alert; ?>
        </div>

<?php
    endforeach;
endforeach;

?>
