
<?php

include("Conexion.php");
//login

session_start();


if(isset($_SESSION['id_registro'])){
    session_destroy();
    header('Location:Form.php');
} 


if(!empty($_POST["Login"])){
    $name2=mysqli_real_escape_string($conexion, $_POST['name']);
    $user2=mysqli_real_escape_string($conexion, $_POST['user1']);
    $pass2=mysqli_real_escape_string($conexion, $_POST['psw']);
    $password_encriptada=sha1($pass2);
    
    $sql="SELECT id,tipo_usuario FROM usuarios WHERE usuario='$user2' and nombre='$name2' and contrasena='$password_encriptada'"; 
    $Resultado = $conexion->query($sql);
    $Rows = $Resultado->num_rows;

    $Resultado2 = $conexion->query($sql);
    $Rows2 = $Resultado2->num_rows;
    
    if ($Rows >= 1) {

        $Row = $Resultado->fetch_assoc();
        $_SESSION['id_registro'] = $Row['id'];

        $Row2 = $Resultado2->fetch_assoc();
        $_SESSION['id_usuario'] = $Row2['tipo_usuario'];





        $tipoUsuario = $Row['tipo_usuario'];
		
        if ($tipoUsuario == 1) {
            header("location: Form 1.php");
        } elseif ($tipoUsuario == 2) {
            header("location: Form 2.php");
        } elseif ($tipoUsuario == 3) {
            header("location: Form 3.php");
        } else {
            echo "<script>
                      alert('Usuario en mantenimiento');
                      window.location.Form.php;
                 </script>";
        }
    } else {
        echo "<script>
                    alert('Usuario o Contraseña incorrecta');
                    window.location.Form.php;
					
                </script>";
				session_destroy();
    }
}

//register
if (isset($_POST["registrar"])) {
    $nombre=mysqli_real_escape_string($conexion, $_POST['nombre']);

    $user=mysqli_real_escape_string($conexion, $_POST['user']);
    $pass=mysqli_real_escape_string($conexion, $_POST['pass']);
	$correo=mysqli_real_escape_string($conexion, $_POST['correo']);
    $password_encriptada=sha1($pass);

    $sqluser="SELECT id FROM usuarios WHERE usuario='$user' "; 
	$resultadouser=$conexion->query($sqluser);
    $filas=$resultadouser->num_rows;
	$numeroAleatorio = rand(1, 3);
	$sqlTipoUsuario = "SELECT id FROM tipos_usuario WHERE id = $numeroAleatorio";
	$resultadoTipoUsuario = $conexion->query($sqlTipoUsuario);

	
    if($filas>=1){
        echo "<script>
                alert('El usuario ya existe o no digito nada ');
                window.location.index.php;
            </script>";
    }else{
        //insertar el registro

		
		$filaTipoUsuario = $resultadoTipoUsuario->fetch_assoc();
		$idTipoUsuario = $filaTipoUsuario['id'];
	
        $sqlusuario="insert into usuarios(Nombre, Correo, Usuario, contrasena, tipo_usuario)
                        values('$nombre','$correo','$user','$password_encriptada','$idTipoUsuario')";

        $resultadousuario=$conexion->query($sqlusuario);

        if($resultadousuario>0){
            echo "<script>
                    alert('Registro exitoso');
                    window.location.Form.php;
                </script>";
        }else{
            echo "<script>
                    alert('Error al registrar');
                    window.location.Form.php;
                </script>";
        }
    }
}


?>



<!doctype html>
<html lang="en">
<head>
  <title>Inicio de Sesion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="Diseño.css">
</head>
<body>

<form action="" method="POST">
	<div class="section">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
			          	<input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
			          	<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Log In</h4>
											<div class="form-group">
												<input type="text" class="form-style" placeholder="Nombre" name="name">
												<i class="input-icon uil uil-edit"></i>
											</div>	
											<div class="form-group mt-2">
												<input type="text" class="form-style" placeholder="Usuarios" name="user1">
												<i class="input-icon uil uil-user"></i>
											</div>	
                                            <div class="form-group mt-2">
												<input type="password" class="form-style" placeholder="Password" name="psw">
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
                                            <input type="submit" class="btn mt-4" value="Login" name="Login" >
                      <p class="mb-0 mt-4 text-center"><a href="https://www.web-leb.com/code" class="link">Forgot your password?</a></p>
				      					</div>
			      					</div>
			      				</div>
								<div class="card-back">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-3 pb-3">Sign Up</h4>
											<div class="form-group">
												<input type="text" class="form-style" name="nombre"placeholder="Nombre">
												<i class="input-icon uil uil-edit"></i>
											</div>	
											<div class="form-group mt-2">
												<input type="email" class="form-style" name="correo"placeholder="Correo">
												
												<i class="input-icon uil uil-at"></i>
											</div>	
                                            <div class="form-group mt-2">
												<input type="text" class="form-style" name="user"placeholder="User">
												<i class="input-icon uil uil-user"></i>
											</div>
											<div class="form-group mt-2">
												<input type="password" class="form-style" name="pass" placeholder="Contraseña">
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
											<button type="submit" name="registrar" class="btn mt-4">Register</button>

				      					</div>
			      					</div>
			      				</div>
			      			</div>
			      		</div>
			      	</div>
		      	</div>
	      	</div>
	    </div>
	</div>
    </form>
</body>
</html>