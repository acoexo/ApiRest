<?php
/**
 * Clase Categoria para manejar categorías en la base de datos.
 */
class Categoria extends Conectar{
    /**
     * Obtiene todas las categorías disponibles.
     *
     * @return array Arreglo asociativo con las categorías.
     */
    public function get_categoria(){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM tm_categoria WHERE est=1";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Obtiene una categoría por su ID.
     *
     * @param int $cat_id ID de la categoría.
     * @return array Arreglo asociativo con la información de la categoría.
     */
    public function get_categoria_x_id($cat_id){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM tm_categoria WHERE est=1 AND cat_id = :cat";
        $sql=$conectar->prepare($sql);
        $sql->bindParam(':cat',$cat_id, PDO::PARAM_INT);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Inserta una nueva categoría en la base de datos.
     *
     * @param string $cat_nom Nombre de la categoría.
     * @param string $cat_obs Observación de la categoría.
     * @return array Arreglo asociativo con la información de la categoría insertada.
     */
    public function insert_categoria($cat_nom, $cat_obs){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="INSERT INTO tm_categoria VALUES (default, :nomb, :obse, 1)";
        $sql=$conectar->prepare($sql);
        $sql->bindParam(":nomb",$cat_nom,PDO::PARAM_STR);
        $sql->bindParam(":obse",$cat_obs,PDO::PARAM_STR);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
     /**
     * Actualiza una categoría existente en la base de datos.
     *
     * @param int $cat_id ID de la categoría a actualizar.
     * @param string $cat_nom Nuevo nombre de la categoría.
     * @param string $cat_obs Nueva observación de la categoría.
     * @return array Arreglo asociativo con la información de la categoría actualizada.
     */
    public function update_categoria($cat_id, $cat_nom, $cat_obs){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="UPDATE tm_categoria set 
        cat_nom=:nomb, 
        cat_obs=:obse
        WHERE 
        cat_id= :id";
        $sql=$conectar->prepare($sql);
        $sql->bindParam(":id",$cat_id,PDO::PARAM_INT);
        $sql->bindParam(":nomb",$cat_nom,PDO::PARAM_STR);
        $sql->bindParam(":obse",$cat_obs,PDO::PARAM_STR);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Elimina una categoría de la base de datos.
     *
     * @param int $cat_id ID de la categoría a eliminar.
     * @return array Arreglo asociativo con la información de la categoría eliminada.
     */
    public function delete_categoria($cat_id){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="UPDATE tm_categoria set 
        est=0
        WHERE 
        cat_id= :id";
        $sql=$conectar->prepare($sql);
        $sql->bindParam(":id",$cat_id,PDO::PARAM_INT);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
    

}
?>
