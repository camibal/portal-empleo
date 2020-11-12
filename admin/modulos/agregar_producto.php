<?php
check_admin();

if (isset($enviar)) {
    $name = clear($name);
    $telefono = clear($telefono);
    $email = clear($email);
    $age = clear($age);
    $categoria = clear($categoria);
    $descripcion = clear($descripcion);

    $imagen = "";

    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        $imagen = $name . rand(0, 1000) . ".png";
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../productos/" . $imagen);
    }

    $mysqli->query("INSERT INTO productos (name,price,imagen,email,age,id_categoria,descripcion) VALUES ('$name','$telefono','$imagen','$email','$age','$categoria','$descripcion')");
    echo "<script>alert('Trabajador agregado exitosamente')</script>";
    redir("?p=agregar_producto");
}

if (isset($eliminar)) {
    $mysqli->query("DELETE FROM productos WHERE id = '$eliminar'");
    redir("?p=agregar_producto");
}


?>

<h1>Agregar Trabajador</h1><br><br>

<form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" class="form-control" name="name" placeholder="Nombre" />
    </div>
    <div class="form-group">
        <label>Correo</label>
        <input type="email" class="form-control" name="email" placeholder="Correo" />
    </div>
    <div class="form-group">
        <label>Edad</label>
        <input type="number" class="form-control" name="age" placeholder="Edad" />
    </div>
    <div class="form-group">
        <label>Descripcion</label>
        <textarea class="form-control" name="descripcion" placeholder="Descripciòn"></textarea>
    </div>
    <div class="form-group">
        <label>Telefono</label>
        <input type="text" class="form-control" name="telefono" placeholder="Telefono" />
    </div>
    <div class="form-group">
        <label>Fotografia</label>
        <input type="file" class="form-control" name="imagen" title="Imagen del producto" placeholder="Imagen del producto" />
    </div>

    <div class="form-group">
        <label>Categoria</label>
        <select name="categoria" required class="form-control">
            <option value="">Seleccione una categoria</option>
            <?php
            $q = $mysqli->query("SELECT * FROM categorias ORDER BY categoria ASC");

            while ($r = mysqli_fetch_array($q)) {
            ?>
                <option value="<?= $r['id'] ?>"><?= $r['categoria'] ?></option>
            <?php
            }
            ?>
        </select>

    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="enviar"><i class="fa fa-check"></i> Agregar</button>
    </div>

</form><br>

<br>
<div class="scrollmenu">
    <table class="table table-bordered text-center">

        <tr class="bg-secondary text-light">
            <th class="p-5">Foto</th>
            <th class="p-5">Nombre</th>
            <th class="p-5">Descripciòn</th>
            <th class="p-5">Telefono</th>
            <th class="p-5">Categoria</th>
            <th class="p-5">Acciones</th>
        </tr>

        <?php
        $prod = $mysqli->query("SELECT * FROM productos ORDER BY id DESC");
        while ($rp = mysqli_fetch_array($prod)) {
            $preciototal = 0;

            $cat = $mysqli->query("SELECT * FROM categorias WHERE id = '" . $rp['id_categoria'] . "'");

            if (mysqli_num_rows($cat) > 0) {
                $rcat = mysqli_fetch_array($cat);
                $categoria = $rcat['categoria'];
            } else {
                $categoria = "--";
            }

        ?>
            <tr>
                <td style="width: 10%;"><img src="../productos/<?= $rp['imagen']; ?>" width="50%" /></td>
                <td><?= $rp['name'] ?></td>
                <td><?= $rp['descripcion'] ?></td>
                <td><?= $rp['price'] ?></td>
                <td><?= $categoria ?></td>
                <td>
                    <a style="color:#08f" href="?p=modificar_producto&id=<?= $rp['id'] ?>"><i class="fa fa-edit"></i></a>
                    &nbsp;
                    <a style="color:#08f" href="?p=agregar_producto&eliminar=<?= $rp['id'] ?>"><i class="fa fa-times"></i></a>
                </td>
            </tr>
        <?php
        }
        ?>

    </table>
</div>