<!DOCTYPE html>
<?php session_start();
	/*Aqui se verifica si ya se ingreso la IP del dispositivo,
	  por el paso de variables por metodo POST se puede
	  ver si el boton de nuestra pagina de inicio ya se presiono,
	  en ese caso, se crea una variable de sesion con la IP
	  que ya se ingreso y se redirecciona a la pagina que interactua
	  con nuestro dispositivo*/
	if(isset($_POST["boton"])){
		$_SESSION["ip"] = $_POST["ip"];
		header("location:proceso.php");
	}
	/*en caso de no haber presionado el boton se queda en esta pagina
	  para poder ingresar la IP del dispositivo*/
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Simulación</title>
		<link rel="stylesheet" medi="screen" type="text/css" href="css/estilo.css">
	</head>
	<body>
		<div id="cuadroIP">
			<form action="" method="post" name="formulario1">
				<p class="textos">Bienvenido a la simulación</p>
				<input type="text" placeholder="Direccion IP del dispositivo de control" name="ip" class="cuadroRellenar">
				<button type="submit" name="boton" class="boton">
					<b>Aceptar</b>
				</button>
			</form>
		</div>
	</body>
</html>
