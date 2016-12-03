<?php session_start();

	if(!isset($_SESSION["ip"])){
		header("location:proceso.php");
	}
/*
	if(isset($_POST["botonGadejo"])){

		require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';
		$modbus = new ModbusMaster($_SESSION["ip"], "TCP");

		try {
			$coilLuz = $modbus->readCoils(0, 508, 1);

			if($coilLuz[0] == 1){
				$coilLuz[0] = 0;
			}else{
				$coilLuz[0] = 1;
			}

			$modbus->writeSingleCoil(0, 508, $coilLuz);
		} catch(Exception $e) {
			echo $modbus;
			echo $e;
			exit;
		}
	}*/

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Simulación</title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
	</head>
	<body>
	<div class='banner'>
		<img src='img/bannerPresentacion.png'>
	</div>
	<div class='cuadroPrincipal'>
		<img src='img/tanque.png' class='tanque'>
		<img src='img/agua.jpg' class='agua'>
		<img src='img/tuberias.png' class='tuberias'>
		<div class='bombaB1'>
			<img src='img/bombaAgua.png'>
		</div>
		<div class='bombaB2'>
			<img src='img/bombaAgua.png'>
		</div>
		<div class="valvula">
			<img src='img/valvulaCerrada.png'>
		</div>
		<img src='img/higrometroF.png' class='higrometro'>
		<img src='img/higrometroA.png' class='aguja'>
		<img src='img/termometroF.png' class='termometro'>
		<img src='img/mercurio.jpg' class='mercurio'>
		<div class='vivero'>
			<img src='img/viveroLuzEncendida.png' class='imagenVivero'>
		</div>
		<form action="" method="post" name="formulario1" class='gad'>
			<button type="submit" name="botonGadejo" class='botonGadejo'>
				<img src='img/gadejo_on.png' class='gadejo'>
			</button>
		</form>
		<div class="porcentajeTanque">
			<p></p>
		</div>
		<div class="nivelHumedad">
			<p></p>
		</div>
		<div class="centigrado">
			<p></p>
		</div>
		<div class="fahrenheit">
			<p></p>
		</div>
		<img src='img/grass.png' class='grass'>
	</div>
	<script type="text/javascript" src="js/script.js"></script>
	</body>
</html>
