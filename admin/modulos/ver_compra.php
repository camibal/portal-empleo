<?php
check_admin();

$id = clear($id);

$s = $mysqli->query("SELECT * FROM compra WHERE id = '$id'");
$r = mysqli_fetch_array($s);

$sc = $mysqli->query("SELECT * FROM clientes WHERE id = '" . $r['id_cliente'] . "'");
$rc = mysqli_fetch_array($sc);

$nombre = $rc['name'];

?>
<h1>Viendo compra de <span style="color:#08f"><?= $nombre ?></span></h1><br>

Fecha: <?= fecha($r['fecha']) ?><br>
Estado: <?= estado($r['estado']) ?><br>
<br>
<div class="scrollmenu">
    <table class="table-bordered text-center">
        <tr class="bg-secondary text-light">
            <th>
                <h4 class="p-5">Imagen</h4>
            </th>
            <th>
                <h4 class="p-5">Nombre</h4>
            </th>
            <th>
                <h4 class="p-5">Telefono<h4>
            </th>
        </tr>
        <?php
        $sp = $mysqli->query("SELECT * FROM productos_compra WHERE id_compra = '$id'");
        while ($rp = mysqli_fetch_array($sp)) {

            $spro = $mysqli->query("SELECT * FROM productos WHERE id = '" . $rp['id_producto'] . "'");
            $rpro = mysqli_fetch_array($spro);

            $nombre_producto = $rpro['name'];
            $imagen = $rpro['imagen'];

        ?>
            <tr>
                <td class="p-6" style="width: 30%;">
                    <img src="../productos/<?= $imagen ?>" class="img-admin-ver-producto" width="20%" alt=""><br>
                </td>
                <td class="p-6">
                    <?= $nombre_producto ?>
                </td>
                <td class="p-6">
                    <div><?= $rpro['price'] ?></div>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>