<?php
check_admin();

$id = $_GET['id'];
echo "<script>console.log($id)</script>";
$productos = "SELECT * FROM categorias WHERE id = '$id'";

if (isset($enviar)) {
    $categoria = clear($categoria);


    $mysqli->query("UPDATE categorias SET categoria='$categoria' WHERE id = '$id'");
    redir("?p=agregar_categoria");
}

?>

<form method="post" action="">
    <?php $resultado = mysqli_query($mysqli, $productos);
    while ($row = mysqli_fetch_assoc($resultado)) { ?>
        <div class="form-group">
            <input type="text" class="form-control" name="categoria" value="<?php echo $row['categoria'] ?>" placeholder="Categoria" />
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="enviar" value="Editar categoria" />
        </div>
    <?php
    }
    ?>
</form>