<?php
if (isset($_SESSION['id_cliente'])) {
	redir("./");
}

if (isset($enviar)) {
	$username = clear($username);
	$password = clear($password);

	$pass = password_hash($password, PASSWORD_DEFAULT);
	echo "<script>console.log($password)</script>";

	$q = $mysqli->query("SELECT * FROM clientes WHERE username = '$username' AND password = '$password'");

	if (mysqli_num_rows($q) > 0) {
		$r = mysqli_fetch_array($q);
		$_SESSION['id_cliente'] = $r['id'];
		if (isset($return)) {
			redir("?p=" . $return);
		} else {
			redir("index.php");
		}
	} else {
		echo "<script>alert('El usuario o la contraseña son incorrectos');</script>";
	}
}
?>

<div class="container">

	<!-- Outer Row -->
	<div class="row justify-content-center">

		<div class="col-xl-10 col-lg-12 col-md-9">

			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">
						<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
						<div class="col-lg-6">
							<div class="p-5">
								<div class="text-center">
									<h1 class="h4 text-gray-900 mb-4">Iniciar Sesiòn</h1>
								</div>
								<form class="user" method="POST" action="">
									<div class="form-group">
										<input type="text" class="form-control form-control-user" id="exampleInputEmail" name="username" aria-describedby="emailHelp" placeholder="Usuario">
									</div>
									<div class="form-group">
										<input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
									</div>
									<div class="form-group">
										<div class="custom-control custom-checkbox small">
											<input type="checkbox" class="custom-control-input" id="customCheck">
											<label class="custom-control-label" for="customCheck">Recordar</label>
										</div>
									</div>
									<button class="btn btn-primary btn-user btn-block" type="submit" name="enviar">
										Iniciar Sesiòn
									</button>
									<hr>
									<a class="btn btn-google btn-user btn-block">
										<i class="fab fa-google fa-fw"></i> Iniciar Sesiòn con Google
									</a>
									<a href="index.html" class="btn btn-facebook btn-user btn-block">
										<i class="fab fa-facebook-f fa-fw"></i> Iniciar Sesiòn con Facebook
									</a>
								</form>
								<hr>
								<div class="text-center">
									<a class="small text-dark" href="forgot-password.html">¿Olvidaste la contraseña?</a>
								</div>
								<div class="text-center">
									<a class="small text-dark" href="?p=registro">Crear una cuenta!</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

</div>