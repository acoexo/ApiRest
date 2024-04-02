<?php
/**
 * Clase Producto para manejar productos en la base de datos.
 */
class Producto extends Conectar{
     /**
     * Obtiene todas las categorías disponibles.
     *
     * @return array Arreglo asociativo con las categorías (cat_id y cat_nom).
     */
    public function get_categorias(){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="SELECT cat_id, cat_nom FROM tm_categoria WHERE est=1";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Obtiene todos los productos disponibles.
     *
     * @return array Arreglo asociativo con los productos.
     */
    public function get_producto(){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM tm_producto WHERE est=1";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
     /**
     * Obtiene un producto por su ID.
     *
     * @param int $pro_id ID del producto.
     * @return array Arreglo asociativo con la información del producto.
     */
    public function get_producto_x_id($pro_id){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM tm_producto WHERE est=1 AND pro_id = :pro";
        $sql=$conectar->prepare($sql);
        $sql->bindParam(':pro',$pro_id, PDO::PARAM_INT);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
     /**
     * Inserta un nuevo producto en la base de datos.
     *
     * @param string $pro_nom Nombre del producto.
     * @param string $pro_des Descripción del producto.
     * @param int $cat_id ID de la categoría del producto.
     * @return int Número de filas afectadas por la inserción.
     */
    public function insert_producto($pro_nom, $pro_des, $cat_id){
        $conectar=parent::conexion();
        parent::set_names();
        $sql_verificar = "SELECT COUNT(*) as count FROM tm_categoria WHERE cat_id = :cat_id";
        $stmt = $conectar->prepare($sql_verificar);
        $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        if($count > 0){
            $sql_insert = "INSERT INTO tm_producto (pro_nom, pro_des, pro_cat_id, pro_cat_nom, est) VALUES (:nomb, :desc, :pro_cat_id, :pro_cat_nom, 1)";
            $sql = $conectar->prepare($sql_insert);
            $sql->bindParam(":nomb", $pro_nom, PDO::PARAM_STR);
            $sql->bindParam(":desc", $pro_des, PDO::PARAM_STR);
            $sql->bindParam(":pro_cat_id", $cat_id, PDO::PARAM_INT);
            $sql_get_cat_name = "SELECT cat_nom FROM tm_categoria WHERE cat_id = :cat_id";
            $stmt_cat_name = $conectar->prepare($sql_get_cat_name);
            $stmt_cat_name->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
            $stmt_cat_name->execute();
            $cat_name = $stmt_cat_name->fetch(PDO::FETCH_ASSOC)['cat_nom'];
            
            $sql->bindParam(":pro_cat_nom", $cat_name, PDO::PARAM_STR);
            
            $sql->execute();
            return $sql->rowCount();
        } else {
            return 0;
        }
    }
    /**
     * Actualiza un producto existente en la base de datos.
     *
     * @param int $pro_id ID del producto a actualizar.
     * @param string $pro_nom Nuevo nombre del producto.
     * @param string $pro_des Nueva descripción del producto.
     * @param int $cat_id Nuevo ID de la categoría del producto.
     * @return int Número de filas afectadas por la actualización.
     */
    public function update_producto($pro_id, $pro_nom, $pro_des, $cat_id){
        $conectar=parent::conexion();
        parent::set_names();
        $sql_verificar = "SELECT COUNT(*) as count FROM tm_categoria WHERE cat_id = :cat_id";
        $stmt = $conectar->prepare($sql_verificar);
        $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        if($count > 0){
            $sql_update = "UPDATE tm_producto SET pro_nom = :nomb, pro_des = :desc, pro_cat_id = :cat_id, pro_cat_nom = :pro_cat_nom WHERE pro_id = :id";
            $sql = $conectar->prepare($sql_update);
            $sql->bindParam(":id", $pro_id, PDO::PARAM_INT);
            $sql->bindParam(":nomb", $pro_nom, PDO::PARAM_STR);
            $sql->bindParam(":desc", $pro_des, PDO::PARAM_STR);
            $sql->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
            $sql_get_cat_name = "SELECT cat_nom FROM tm_categoria WHERE cat_id = :cat_id";
            $stmt_cat_name = $conectar->prepare($sql_get_cat_name);
            $stmt_cat_name->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
            $stmt_cat_name->execute();
            $cat_name = $stmt_cat_name->fetch(PDO::FETCH_ASSOC)['cat_nom'];
            
            $sql->bindParam(":pro_cat_nom", $cat_name, PDO::PARAM_STR);
            
            $sql->execute();
            return $sql->rowCount();
        } else {
            return 0;
        }
    }
    /**
     * Elimina un producto de la base de datos.
     *
     * @param int $pro_id ID del producto a eliminar.
     * @return int Número de filas afectadas por la eliminación.
     */
    public function delete_producto($pro_id){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="UPDATE tm_producto set 
        est=0
        WHERE 
        pro_id= :id";
        $sql=$conectar->prepare($sql);
        $sql->bindParam(":id",$pro_id,PDO::PARAM_INT);
        $sql->execute();
        return $sql->rowCount(); 
    }

}
?>
