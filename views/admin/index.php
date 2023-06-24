<h1 class="name-page">Panel de administración</h1>
<?php include_once __DIR__ . "/../templates/userSection.php" ?>

<div>
    <form class="form" action="/admin" method="POST">
        <fieldset>
            <legend>Filtrar citas</legend>
            <div class="field">
                <label for="appointmentId">#</label>
                <input type="number" name="appointmentId" id="appointmentId" placeholder="Número de cita" value="<?php echo $appointmentId ?>">
            </div>
            <div class="field">
                <label for="appointmentDate">Fecha</label>
                <input type="date" name="appointmentDate" id="appointmentDate" value="<?php echo $appointmentDate; ?>">
            </div>
            <div class="field">
                <label for="appointmentUser">Cliente</label>
                <input type="text" name="appointmentUser" id="appointmentUser" placeholder="Cliente" value="<?php echo $appointmentUser ?>">
            </div>
            <div class="field">
                <label for="appointmentEmail">E-mail</label>
                <input type="text" name="appointmentEmail" id="appointmentEmail" placeholder="E-mail" value="<?php echo $appointmentEmail ?>">
            </div>
        </fieldset>
            <input type="submit" value="Buscar" class="button">
    </form>
</div>

<div class="admin-appointments">
    <?php if (!$appointments): ?>
        <h2>No hay citas registradas para la fecha</h2>
    <?php else: ?>
        <?php if (isMobile()): 
            $lastAppointmentId = 0;
            foreach ($appointments as $appointment): 
                if ($lastAppointmentId != $appointment->appointmentId): 
                    $lastAppointmentId = $appointment->appointmentId; ?>
                    <hr>
                    <ul>
                        
                        <li>
                            <span>#:</span> <?php echo $appointment->appointmentId ?>
                        </li>

                        <li>
                            <span>Fecha:</span> <?php echo $appointment->appointmentDate ?>
                        </li>

                        <li>
                            <span>Cliente:</span> <?php echo $appointment->fullName ?>
                        </li>

                        <li>
                            <span>E-mail:</span> <?php echo $appointment->email ?>
                        </li>

                        <li>
                            <span>Precio total:</span> $ <?php echo $appointment->appointmentTotal ?>
                        </li>
        
                    </ul>
                    <h3>Servicios</h3>
                <?php endif; ?>

                <p class="service-desc"><?php echo "{$appointment->serviceName} - {$appointment->servicePrice}" ?></p>

                
            <?php endforeach; ?>
        <?php else: ?>

            <table class="table-appointments" cellspacing="0">
                <thead>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>E-mail</th>
                    <th>Total</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr appointmentId="<?php echo $appointment->appointmentId; ?>">
                            <td><?php echo $appointment->appointmentId ?></td>
                            <td><?php echo $appointment->appointmentDate ?></td>
                            <td><?php echo $appointment->fullName ?></td>
                            <td><?php echo $appointment->email ?></td>
                            <td>$ <?php echo $appointment->appointmentTotal ?></td>
                            <td><img class="arrow-icon" name="detailsButton" data-id-appointment="<?php echo $appointment->appointmentId ?>" src="build/img/arrow.webp" alt="arrow.png"></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        <?php endif; ?>
    <?php endif; ?>

</div>


<?php 
    $script = "
        <script src='build/js/adminAppointment.js' type='module'></script>
    ";
?>
