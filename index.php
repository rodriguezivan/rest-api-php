<?php
header("Content-type: application/json;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");

$method = $_SERVER["REQUEST_METHOD"]; //Obtiene la acción HTTP: POST, GET, DELETE, PUT.

$request_uri = $_SERVER["REQUEST_URI"]; //Obtiene la URI completa.

$tables = ["actas"]; //Recursos permitidos por la API.

$url = rtrim($request_uri, "/");
$url = filter_var($request_uri, FILTER_SANITIZE_URL);
$url = explode("/", $url);

$tableName = (string) $url[4];

if (count($url) >=6 && $url[5] != null) {
    $id = (int) $url[5];
} else {
    $id = null;
}

if (in_array($tableName, $tables)) {
    include_once "./classes/Database.php";
    include_once "./api/actas.php";        
} else {
    echo "Recurso no existente en la API.";
}




