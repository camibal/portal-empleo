<?php
if (isset($_SESSION['id_cliente'])) {
    redir("./");
}

if (isset($enviar)) {
    $nombre = clear($nombre);
    $username = clear($username);
    $password = clear($password);
    $cpassword = clear($cpassword);
    $email = clear($email);
    $celular = clear($celular);

    $pass = password_hash($password, PASSWORD_DEFAULT);

    $q = $mysqli->query("SELECT * FROM clientes WHERE username = '$username'");

    if (mysqli_num_rows($q) > 0) {
        echo "<script>alert('El usuario ya está en uso',0,'registro');location.href='?p=registro'</script>";
        die();
    }

    if ($password != $cpassword) {
        echo "<script>alert('Las contraseñas no coinciden'); location.href='?p=registro'</script>";
        die();
    }
    $mysqli->query("INSERT INTO clientes (username,password,name,email,celular) VALUES ('$username','$password','$nombre','$email','$celular')");


    $q2 = $mysqli->query("SELECT * FROM clientes WHERE username = '$username'");

    $r = mysqli_fetch_array($q2);

    echo "<script>alert('Te haz registrado exitosamente'); location.href='?p=login'</script>";
}
?>
<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Crear Una Cuenta!</h1>
                        </div>
                        <form class="user" method="POST" action="">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="Nombre" name="nombre">
                                </div>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Correo" name="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputUser" placeholder="Usuario" name="username">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Contraseña" name="password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repetir Contraseña" name="cpassword">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" id="exampleInputPhone" placeholder="Telefono" name="celular">
                            </div>
                            <button type="submit" name="enviar" class="btn btn-primary btn-user btn-block">
                                Registrar Cuenta
                            </button>
                            <hr>
                            <a href="#" class="btn btn-google btn-user btn-block">
                                <i class="fab fa-google fa-fw"></i> Registrar con Google
                            </a>
                            <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                <i class="fab fa-facebook-f fa-fw"></i> Registrar con Facebook
                            </a>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small text-dark" href="?p=login">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>