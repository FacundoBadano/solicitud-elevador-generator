<?php

echo '<h2> Generar simulaciones </h2><hr>';
echo '<p> Formato: Colan,77,2,1,1</p>';

$cantidadSolicitudes = $_POST['cantidad_solicitudes']; 
$tiempo_minimo = $_POST['tiempo_minimo'];
$tiempo_maximo = $_POST['tiempo_maximo']; 

// Leer los nombres del archivo CSV
$nombres = array();
if (($handle = fopen("Nombres.csv", "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        $nombres[] = $data[0]; // Ajusta el índice según la columna del nombre en tu archivo CSV
    }
    fclose($handle);
}

// Verificar si el archivo de salida existe
$archivoSalida = "simulacion.csv";

// Abrir el archivo de salida CSV en modo de escritura (crear si no existe)
$archivoSalida = fopen($archivoSalida, "w");

if ($crearArchivo) {
    // Escribir encabezados de columna si se crea el archivo
    $encabezados = array("Nombre", "Peso", "Piso Origen", "Piso Destino");
    fputcsv($archivoSalida, $encabezados);
}

$salidaSolicitudes = array();

for($i = 1; $i <= $cantidadSolicitudes; $i++){
    $nombrePasajero = $nombres[array_rand($nombres)]; // Obtener un nombre aleatorio del array de nombres
    $pisoOrigen = obtenerPisoOrigen();
    $pisoDestino = obtenerPisoDestino($pisoOrigen);
    $pesoPasajero = obtenerPeso();
    $tiempoSolicitud = obtenerTiempoSolicitud($tiempo_minimo, $tiempo_maximo);


    // Escribir la información en el archivo CSV
    $linea = array($nombrePasajero, $pesoPasajero, $pisoOrigen, $pisoDestino, $tiempoSolicitud);
    fputcsv($archivoSalida, $linea);


    echo 'Se agrega al archivo la solicitud: '.$nombrePasajero.",".$pesoPasajero.",".$pisoOrigen.",".$pisoDestino.",".$tiempoSolicitud."<br>";
    // exit();
}

// Cerrar el archivo de salida CSV
fclose($archivoSalida);

function obtenerPisoOrigen(){
    return rand(1,9);
}

function obtenerPeso(){
    return rand(70,100);
}

function obtenerTiempoSolicitud($min,$max){
    return rand($min, $max);
}

function obtenerPisoDestino($pisoOrigen) {
    do {
        $n = mt_rand(1,9);
    } while(in_array($n, array($pisoOrigen)));

    return $n;
}

?>