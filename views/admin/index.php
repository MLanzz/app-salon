<h1 class="name-page">Panel de administración</h1>
<?php include_once __DIR__ . "/../templates/userSection.php" ?>


<h2>Filtrar citas</h2>
<div>
    <form class="form" action="/admin" method="POST">
        <div class="field">
            <label for="appointmentDate">Fecha</label>
            <input type="date" name="appointmentDate" id="appointmentDate" value="<?php echo $date; ?>">
        </div>
        <input type="submit" value="Buscar" class="button">
    </form>
</div>

<div class="admin-appointments">
    <?php if (!$appointments): ?>
        <p>No hay citas registradas para la fecha</p>
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

</div>


<?php 
    $script = "
        <script src='build/js/adminAppointment.js' type='module'></script>
    ";
?>
