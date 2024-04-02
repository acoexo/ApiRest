<?php
/**
 * Archivo que maneja las operaciones CRUD para categorías.
 */

header('Content-Type: application/json');
require_once ('../config/conexion.php');
require_once ('../models/Categoria.php');

$categoria = new Categoria();
$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    /**
     * Obtiene todas las categorías.
     */
    case "GetAll":
        $datos = $categoria->get_categoria();
        echo json_encode($datos);
        break;
    
    /**
     * Obtiene una categoría por su ID.
     */
    case "GetId":
        $datos = $categoria->get_categoria_x_id($body["cat_id"]);
        echo json_encode($datos);
        break;
    
    /**
     * Inserta una nueva categoría.
     */
    case "Insert":
        $datos = $categoria->insert_categoria($body['cat_nom'], $body['cat_obs']);
        echo json_encode(array("Alert" => "Correcto"));
        break;
    
    /**
     * Actualiza una categoría existente.
     */
    case "Update":
        $datos = $categoria->update_categoria($body['cat_id'], $body['cat_nom'], $body['cat_obs']);
        echo json_encode(array("Alert" => "Correcto"));
        break;
    
    /**
     * Elimina una categoría.
     */
    case "Delete":
        $datos = $categoria->delete_categoria($body['cat_id']);
        echo json_encode(array("Alert" => "Correcto"));
        break;
    
    /**
     * Maneja la opción por defecto en caso de operación no permitida.
     */
    default:
        echo json_encode(array("Error" => "Operación no permitida"));
}

?>
