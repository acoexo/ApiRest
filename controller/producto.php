<?php
/**
 * Archivo que maneja las operaciones CRUD para productos.
 */

header('Content-Type: application/json');
require_once ('../config/conexion.php');
require_once ('../models/Productos.php');

$producto = new Producto();
$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    /**
     * Obtiene todos los productos.
     */
    case "GetAll":
        $datos = $producto->get_producto();
        echo json_encode($datos);
        break;
    
    /**
     * Obtiene un producto por su ID.
     */
    case "GetId":
        $datos = $producto->get_producto_x_id($body["pro_id"]);
        echo json_encode($datos);
        break;
    
    /**
     * Inserta un nuevo producto.
     */
    case "Insert":
        $datos = $producto->insert_producto($body['pro_nom'], $body['pro_des'], $body['pro_cat_id']);
        if ($datos) {
            echo json_encode(array("Alert" => "Correcto"));
        } else {
            echo json_encode(array("Error" => "Error al insertar el producto"));
        }
        break;
    
    /**
     * Actualiza un producto existente.
     */
    case "Update":
        $datos = $producto->update_producto($body['pro_id'], $body['pro_nom'], $body['pro_des'], $body['pro_cat_id']);
        if ($datos) {
            echo json_encode(array("Alert" => "Correcto"));
        } else {
            echo json_encode(array("Error" => "Error al actualizar el producto"));
        }
        break;
    
    /**
     * Elimina un producto.
     */
    case "Delete":
        $datos = $producto->delete_producto($body['pro_id']);
        if ($datos) {
            echo json_encode(array("Alert" => "Correcto"));
        } else {
            echo json_encode(array("Error" => "Error al eliminar el producto"));
        }
        break;
    
    /**
     * Maneja la opción por defecto en caso de operación no permitida.
     */
    default:
        echo json_encode(array("Error" => "Operación no permitida"));
}
?>
