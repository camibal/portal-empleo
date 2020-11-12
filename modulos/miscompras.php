<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Mis solicitudes ya hechas</h1>
</div>
<?php
check_user('miscompras');
$s = $mysqli->query("SELECT * FROM compra WHERE id_cliente = '" . $_SESSION['id_cliente'] . "' ORDER BY fecha DESC");
if (mysqli_num_rows($s) > 0) {
?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabla</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciòn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($r = mysqli_fetch_array($s)) {
                        ?>
                            <tr>
                                <td><?= fecha($r['fecha']) ?></td>
                                <td><?= estado($r['estado']) ?></td>
                                <td>
                                    <a href="?p=ver_compra&id=<?= $r['id'] ?>" class="text-primary">
                                        <i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="Ver Pedido"></i>
                                    </a>

                                    <?php
                                    if (estado($r['estado']) == "Iniciando") {
                                    ?>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
} else {
?>
    <div class="no-productos text-center mt-5">
        <i>AUN NO HAZ HECHO NINGUNA SOLICITUD PARA EMPLEAR</i>
    </div>
<?php
}
?>