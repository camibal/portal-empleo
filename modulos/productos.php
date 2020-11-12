<?php
check_user("productos");

if (isset($agregar) && isset($cant)) {

  $idp = clear($agregar);
  $cant = clear($cant);
  $id_cliente = clear($_SESSION['id_cliente']);

  $v = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'");

  if (mysqli_num_rows($v) > 0) {

    $q = $mysqli->query("UPDATE carro SET cant = cant + $cant WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'");
  } else {

    $q = $mysqli->query("INSERT INTO carro (id_cliente,id_producto,cant) VALUES ($id_cliente,$idp,$cant)");
  }

  echo "<script>alert('e ha agregado a solicitudes pendientes')</script>";
  redir("?p=productos");
}

if (isset($busq) && isset($cat)) {
  $q = $mysqli->query("SELECT * FROM productos WHERE name like '%$busq%' AND id_categoria = '$cat'");
} elseif (isset($cat) && !isset($busq)) {
  $q = $mysqli->query("SELECT * FROM productos WHERE id_categoria = '$cat' ORDER BY id DESC");
} elseif (isset($busq) && !isset($cat)) {
  $q = $mysqli->query("SELECT * FROM productos WHERE name like '%$busq%'");
} elseif (!isset($busq) && !isset($cat)) {
  $q = $mysqli->query("SELECT * FROM productos ORDER BY id DESC");
} else {
  $q = $mysqli->query("SELECT * FROM productos ORDER BY id DESC");
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Trabajadores</h1>
</div>
<!--/.Carousel Wrapper-->
<form method="post" action="">
  <div class="row align-items-center mb-5">
    <div class="col-md-8">

    </div>
    <div class="col-md-4">
      <select id="categoria" name="cat" onchange="redir_cat()" class="form-control">
        <option value="">Filtra por categoria</option>
        <?php
        $cats = $mysqli->query("SELECT * FROM categorias ORDER BY categoria ASC");
        while ($rcat = mysqli_fetch_array($cats)) {
        ?>
          <option value="<?= $rcat['id'] ?>"><?= $rcat['categoria'] ?></option>
        <?php
        }
        ?>
      </select>
    </div>
  </div>
</form>
<?php
if (isset($cat)) {
  $sc = $mysqli->query("SELECT * FROM categorias WHERE id = '$cat'");
  $rc = mysqli_fetch_array($sc);
?>
  <h2 class="text-center p-5"><?= $rc['categoria'] ?></h2>
<?php
}
?>
<div class="row">
  <?php
  while ($r = mysqli_fetch_array($q)) {
  ?>
    <div class="col-12 col-md-6 col-xl-4 mb-4">
      <div class="card shadow mb-4 card-producto">
        <div class="card-header py-3">

        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-5">
              <div class="text-left">
                <img class="img-fluid img-trabajador px-3 px-sm-4 mt-3 mb-4" style="width: 10rem;" src="productos/<?= $r['imagen'] ?>" alt="">
              </div>
            </div>
            <div class="col-12 col-md-7">
              <div class="text-left p-2">
                <strong class="text-uppercase"> <?= $r['name'] ?> </strong>
              </div>
              <div class="text-left p-2">
                <span class="text-uppercase"><?= $r['especializacion'] ?></span>
              </div>
              <div class="text-left p-2">
                <span> <?= $r['age'] ?> años </span>
              </div>
              <div class="text-left p-2 mb-3">
                <span><?= $r['price'] ?></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <p class="text-description"><?= $r['descripcion'] ?></p>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-12 d-flex justify-content-end">
              <input type="hidden" id="cant<?= $r['id'] ?>" name="cant" class="cant pull-right input_cantidad_principal" value="1">
              <button class="btn bg-gradient-primary text-light btn-md mr-3" onclick="agregar_carro('<?= $r['id'] ?>');">SOLICITAR</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
  }
  ?>
</div>
<script type="text/javascript">
  function agregar_carro(idp) {

    cant = $("#cant" + idp).val();

    if (cant.length > 0) {
      window.location = "?p=productos&agregar=" + idp + "&cant=" + cant;
    }
  }

  function redir_cat() {

    window.location = "?p=productos&cat=" + $("#categoria").val();

  }
</script>