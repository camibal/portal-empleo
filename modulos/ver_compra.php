<?php
check_user('ver_compra');
$id = clear($id);

$s = $mysqli->query("SELECT * FROM compra WHERE id = '$id' AND id_cliente = '" . $_SESSION['id_cliente'] . "'");

if (mysqli_num_rows($s) > 0) {

    $s = $mysqli->query("SELECT * FROM compra WHERE id = '$id'");
    $r = mysqli_fetch_array($s);

    $sc = $mysqli->query("SELECT * FROM clientes WHERE id = '" . $r['id_cliente'] . "'");
    $rc = mysqli_fetch_array($sc);

    $nombre = $rc['name'];

?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mi Solicitud</h1>
    </div>
    <div class="row mt-5">
        <i class="fa fa-calendar text_orange ml-3"></i>&nbsp &nbsp Fecha: <?= fecha($r['fecha']) ?>
    </div>
    <div class="row">
        <i class="fa fa-outdent text_orange ml-3"></i>&nbsp &nbsp Estado: <?= estado($r['estado']) ?>
    </div>
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
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sp = $mysqli->query("SELECT * FROM productos_compra WHERE id_compra = '$id'");
                        while ($rp = mysqli_fetch_array($sp)) {

                            $spro = $mysqli->query("SELECT * FROM productos WHERE id = '" . $rp['id_producto'] . "'");
                            $rpro = mysqli_fetch_array($spro);

                            $nombre_producto = $rpro['name'];
                            $telefono = $rpro['price'];
                            $imagen_producto = $rpro['imagen'];
                        ?>
                            <tr>
                                <td><img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-mi-solicitud" src="productos/<?= $imagen_producto ?>" alt=""></td>
                                <td><?= $nombre_producto ?></td>
                                <td><?= $telefono ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--
<?php
    if (estado($r['estado']) == "Iniciando") {
?>
	<a class="btn btn-primary" href="?p=pagar_compra&id=<?= $r['id'] ?>">
		Pagar
	</a>
	<?php
    }
    ?>

<?php

} else {
    echo "<script>alert('Ha ocurrido un error')</script>";
    redir("?p=miscompras");
} ?>-->