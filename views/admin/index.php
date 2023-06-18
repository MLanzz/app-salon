<h1 class="name-page">Panel de administración</h1>
<?php include_once __DIR__ . "/../templates/userSection.php" ?>


<h2>Filtrar citas</h2>
<div class="search">
    <form class="form">
        <div class="field">
            <label for="appointmentDate">Fecha</label>
            <input type="date" name="appointmentDate" id="appointmentDate">
        </div>
    </form>
</div>

<div class="admin-appointments">
    <table class="table-appointments">
        <thead>
            <th>#</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>E-mail</th>
            <th></th>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?php echo $appointment->appointmentId ?></td>
                    <td><?php echo $appointment->appointmentDate ?></td>
                    <td><?php echo $appointment->fullName ?></td>
                    <td><?php echo $appointment->email ?></td>
                    <td><img class="arrow-icon" name="detailsButton" data-id-appointment="<?php echo $appointment->appointmentId ?>" src="build/img/arrow.webp" alt="arrow.png"></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


<?php 
    $script = "
        <script src='build/js/adminAppointment.js' type='module'></script>
    ";
?>
