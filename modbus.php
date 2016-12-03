<?php session_start();

	/*
	Valor de Coils (Digitales)
		500: Sensor bomba 1 (Entrada)
		501: Sensor bomba 2 (Entrada)
		502: Valvula de llenado (Entrada/Salida)
		503: Bomba 1 (Salida)
		504: Bomba 2 (Salida)
		505: Alerta Tempeatura (Salida)
		506: Alerta Humedad (Salida)
		507: Alerta Nivel Tanque (Salida)
		508: Luz de vivero (Gadejo)

	Valor de registros (Analogicos)
		509: Tanque
		510: Termometro
		511: Higrometro
	*/

	//Si no existe la IP del nodeMCU se solicita
	if(!isset($_SESSION["ip"])){
		header("location:proceso.php");
	}

	//Libreria PHPmodbus
	require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';
	$modbus = new ModbusMaster($_SESSION["ip"], "TCP");

	//Si se reciben datos de la pagina para la salida (sin estado de Luz)
	if(isset($_POST["estado_temperatura"])){
		$digital_out[0] = $_POST["bombB1"];
		$digital_out[1] = $_POST["bombB2"];
		$digital_out[2] =$_POST["estado_temperatura"];
		$digital_out[3] = $_POST["estado_higrometro"];
		$digital_out[4] = $_POST["estado_tanque"];
		try {
			$modbus->writeMultipleCoils(0, 503, $digital_out);
		} catch(Exception $e) {
			echo $modbus;
			echo $e;
			exit;
		}
	}

	//Leer del nodeMCU
	try {
		$in_coils = $modbus->readCoils(0, 500, 1);

		$tanque = $modbus->readMultipleRegisters(0, 509, 4);
		//$termometro = $modbus->readMultipleRegisters(0, 510, 4);
		//$higrometro = $modbus->readMultipleRegisters(0, 511, 4);

		$out_coils = $modbus->readCoils(0, 503, 5);

	} catch(Exception $e) {
		echo $modbus;
		echo $e;
		exit;
	}

	$data[] = array(
				"sensorB1"=> $in_coils[0],
				//"sensorB2"=> $coils[1],
				//"valvula" => $coils[2],

				"bombaB1" => $out_coils[0],
				"bombaB2" => $out_coils[1],
				"estado_temperatura" => $out_coils[2],
				"estado_higrometro" => $out_coils[3],
				"estado_tanque" => $out_coils[4],
				//"luz" => $coils[8],

				"tanque" => $tanque[0]*255 + $tanque[1]
				//"termometro" => $termometro[0]*255+$termometro[1],
				//"higrometro" => $higrometro[0]*255+$higrometro[1]
			);

	echo json_encode($data);
?>
