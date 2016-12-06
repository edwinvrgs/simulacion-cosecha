document.addEventListener("DOMContentLoaded", function(event) {
	Actualizar();
});

function Actualizar(salidaS = null) {

	var request = new XMLHttpRequest();
	request.open('POST', 'modbus.php', true);
	request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
	request.responseType = "json";

	request.send(salidaS);

	request.onload = function() {
	  if (request.status >= 200 && request.status < 400) {

			var data = request.response[0];

			//mostrar valor de los sensores analogicos
			actualizarMedidores(data.tanque, data.termometro, data.higrometro);

			//conversion a valores reales
			var temperatura = (data.termometro*90/1024)-40;
			var agua = (data.tanque*100/1024);
			var humedad = (data.higrometro*80/1024)+20;
			var bomb1 = 2;
			var bomb2 = 2;
			var estado_tanque = 1;
			var estado_higrometro = 1;
			var estado_temperatura = 1;

			//mostrar valores reales
			document.querySelector(".porcentajeTanque").innerHTML = "<p>"+parseInt(agua)+"%</p>";
			document.querySelector(".nivelHumedad").innerHTML = "<p>"+parseInt(humedad)+"</p>";
			document.querySelector(".centigrado").innerHTML = "<p>"+parseInt(temperatura)+"</p>";
			document.querySelector(".fahrenheit").innerHTML = "<p>"+parseInt((temperatura*1.8)+32)+"</p>";

			if(agua >= 20){
				if(humedad >= 40){
					if(temperatura >= 30){
						bomb1 = 1;
						if(temperatura >= 40){
							bomb2 = 1;
							estado_temperatura = 0;
						}
					}
				}else {
					bomb1 = 1;
					bomb2 = 1;
					estado_higrometro = 0;
					if(temperatura <= 20){
						bomb2 = 2;
						estado_temperatura = 0;
					}
				}
			}else
				estado_tanque = 0;

			if(data.sensorB1)
				bomb1 = 0;


			if(data.sensorB2)
				bomb2 = 0;


			if(!data.luz){
				document.querySelector(".vivero").innerHTML = "<img class='imagenVivero' src='img/viveroLuzEncendida.png'>";
				document.querySelector(".botonGadejo").innerHTML = "<img src='img/gadejo_on.png' class='gadejo'>";
			}else{
				document.querySelector(".vivero").innerHTML = "<img class='imagenVivero' src='img/viveroLuzApagada.png'>";
				document.querySelector(".botonGadejo").innerHTML = "<img src='img/gadejo_off.png' class='gadejo'>";
			}

			//estado de la valvula de llenado
			if(data.valvula)
				document.querySelector(".valvula").innerHTML = "<img src='img/valvulaAbierta.png'>";
			else
				document.querySelector(".valvula").innerHTML = "<img src='img/valvulaCerrada.png'>";

			var salida = "estado_temperatura="+estado_temperatura+"&estado_higrometro="+estado_higrometro+"&estado_tanque="+estado_tanque;

			//estado del sensor bomba 1
			switch(bomb1){
				case 0:
					document.querySelector(".bombaB1").innerHTML = "<img src='img/bombaSobrecal.png'>";
					salida += "&bombB1=0";
				break
				case 1:
					document.querySelector(".bombaB1").innerHTML = "<img src='img/bombaAgua.png'>";
					salida += "&bombB1=1";
				break
				case 2:
					document.querySelector(".bombaB1").innerHTML = "<img src='img/bombaVacia.png'>";
					salida += "&bombB1=0";
				break
				default:
				break;
			}

		//estado del sensor bomba 2
			switch(bomb2){
				case 0:
					document.querySelector(".bombaB2").innerHTML = "<img src='img/bombaSobrecal.png'>";
					salida += "&bombB2=0";
				break
				case 1:
					document.querySelector(".bombaB2").innerHTML = "<img src='img/bombaAgua.png'>";
					salida += "&bombB2=1";
				break
				case 2:
					document.querySelector(".bombaB2").innerHTML = "<img src='img/bombaVacia.png'>";
					salida += "&bombB2=0";
				break
				default:
				break;
			}

			setTimeout(function() {
				Actualizar(salida);
			}, 50);

	  } else {
	  	alert("Error en el servidor");
	  }
	};

	request.onerror = function() {
	  	alert("Error en la peticion");
	};

};

function actualizarMedidores(nivAgua, nivTemp, nivHum) {
	var cant = 157-(157*nivAgua/1024);
	document.querySelector(".agua").height = cant;
	cant = 285-(285*nivTemp/1024);
	document.querySelector(".mercurio").height = cant;
	cant = 285*nivHum/(1024);
	document.querySelector(".aguja").style.transform = "rotate("+cant+"deg)";
};
