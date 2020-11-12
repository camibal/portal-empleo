<?php

check_user('carrito');

if (isset($eliminar)) {
	$eliminar = clear($eliminar);
	$mysqli->query("DELETE FROM carro WHERE id = '$eliminar'");
	redir("?p=carrito");
}

if (isset($id) && isset($modificar)) {

	$id = clear($id);
	$modificar = clear($modificar);

	$mysqli->query("UPDATE carro SET cant = '$modificar' WHERE id = '$id'");
	// alert("Cantidad modificada",1,'carrito');
	//redir("?p=carrito");


}

if (isset($finalizar)) {
	$direccion = clear($direccion);
	$id_cliente = clear($_SESSION['id_cliente']);
	if ($direccion === "") {
		echo "<script>alert('Al menos debe haber un producto en el carrito, y el campo direccion de entrega es obligatorio')</script>";
		redir("?p=carrito");
	}
	$q = $mysqli->query("INSERT INTO compra (id_cliente,fecha,estado,direccion) VALUES ('$id_cliente',NOW(),0,'$direccion')");

	$sc = $mysqli->query("SELECT * FROM compra WHERE id_cliente = '$id_cliente' ORDER BY id DESC LIMIT 1");
	$rc = mysqli_fetch_array($sc);

	$ultima_compra = $rc['id'];


	$q2 = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente'");
	while ($r2 = mysqli_fetch_array($q2)) {

		$sp = $mysqli->query("SELECT * FROM productos WHERE id = '" . $r2['id_producto'] . "'");
		$rp = mysqli_fetch_array($sp);

		$monto = $rp['price'];

		$mysqli->query("INSERT INTO productos_compra (id_compra,id_producto,cantidad,monto) VALUES ('$ultima_compra','" . $r2['id_producto'] . "','" . $r2['cant'] . "','$monto')");
	}

	$mysqli->query("DELETE FROM carro WHERE id_cliente = '$id_cliente'");

	$sc = $mysqli->query("SELECT * FROM compra WHERE id_cliente = '$id_cliente' ORDER BY id DESC LIMIT 1");
	$rc = mysqli_fetch_array($sc);

	$id_compra = $rc['id'];

	echo "<script>alert('Tu pedido a sido recibido con exito, en poco tiempo nos comunicaremos con tigo al numero registrado en tu sesión.');</script>";
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Solicitudes Pendientes</h1>
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
						<th>Acciòn</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$id_cliente = clear($_SESSION['id_cliente']);
					$q = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente'");
					$monto_total = 0;
					while ($r = mysqli_fetch_array($q)) {
						$q2 = $mysqli->query("SELECT * FROM productos WHERE id = '" . $r['id_producto'] . "'");
						$r2 = mysqli_fetch_array($q2);

						$preciototal = 0;

						$nombre_producto = $r2['name'];

						$cantidad = $r['cant'];

						$precio_unidad = $r2['price'];
						$precio_total = $cantidad * $preciototal;
						$imagen_producto = $r2['imagen'];

						$monto_total = $monto_total + $precio_total;



					?>
						<tr>
							<td><img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 10rem;" src="productos/<?= $imagen_producto ?>" alt=""></td>
							<td><?= $nombre_producto ?></td>
							<td><?= $precio_unidad ?></td>
							<td>
								<a href="?p=carrito&eliminar=<?= $r['id'] ?>" class="text-danger"><i class="fas fa-trash-alt"></i></a>
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

<!-- Button trigger modal -->
<div class="btn-solicitar-servicio d-flex justify-content-center">
	<button type="button" class="btn bg-gradient-primary text-light" data-toggle="modal" data-target="#exampleModal">
		<i class="fa fa-check"></i>Solicitar Servicio
	</button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Confirmar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="">
				<div class="modal-body form-group">
					<input type="hidden" class="form-control" name="monto_total" value="<?= $monto_total ?>" />
					<label for="direccion" class="d-block">Ingrese la direcciòn donde desea el servicio</label>
					<input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion de entrega">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn bg-gradient-primary text-light p-2" type="submit" name="finalizar" id="finalizar"><i class="fa fa-check"></i>
						Confirmar</button>
				</div>
			</form>
		</div>
	</div>
</div>