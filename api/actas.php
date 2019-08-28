<?php
if ($method == "GET") {
    if ($id) {        
        $data = DB::query("SELECT * FROM $tableName WHERE id=:id", array(":id" => $id));
        if($data != null) {
            echo json_encode($data[0], JSON_PRETTY_PRINT);
        } else {
            //header("HTTP/1.0 404 Not Found"); //Retorna resultado de recurso no encontrado. (Regla de "Estado HTTP", de una API REST)
            echo json_encode(["message" => "Acta inexistente", "response" => "Error."],  JSON_PRETTY_PRINT);
        }            
    } else {
        $data = DB::query("SELECT * FROM $tableName ORDER BY numero ASC");
        echo json_encode($data, JSON_PRETTY_PRINT);        
    }
} elseif ($method == "POST") {
    if ($_POST != null || 2==2) { //Mejorar esta condicion y esta parte del codigo.                       
        extract(json_decode(file_get_contents("php://input"), true));
        DB::query("INSERT INTO $tableName VALUES (null, :numero, :titulo, :fecha, :estado)", array(":numero" => $numero, ":titulo" => $titulo, ":fecha" => $fecha, ":estado" => $estado));        
        $data = DB::query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");       
        echo json_encode(["message" => "Acta guardada correctamente.", "response" => "Exito.", "newActa" => $data[0]], JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['message' => "No se puede crear una nueva Acta.", "response" => "Error."]);        
        //header("HTTP/1.1 400 Bad Request"); //Resultado con cabecera HTTP de peticion incorrecta.
    }    
} elseif ($id) {
    $data = DB::query("SELECT * FROM $tableName WHERE id=:id", array(":id" => $id));
    if ($data != null) {
        if ($method == "PUT") {
            extract(json_decode(file_get_contents("php://input"), true));                                     
            DB::query("UPDATE $tableName SET titulo=:titulo, numero=:numero, fecha=:fecha, estado=:estado WHERE id=:id", array(":titulo" => $titulo, ":numero" => $numero, ":fecha" => $fecha, ":estado" => $estado, ":id" => $id));        
            $data = DB::query("SELECT * FROM $tableName WHERE id=:id", array(':id' => $id));
            echo json_encode(['message' => "Acta editada correctamente.", "response" => "Exito.", "actaEdit" => $data[0]], JSON_PRETTY_PRINT);
        } elseif ($method == "DELETE") {
            DB::query("DELETE FROM $tableName WHERE id=:id", array(":id" => $id));
            echo json_encode(["message" => "Acta eliminada correctamente.", "response" => "Exito."], JSON_PRETTY_PRINT);            
        }        
    } else {
        echo json_encode(["message" => "Acta inexistente", "response" => "Error."],  JSON_PRETTY_PRINT);
    }

}