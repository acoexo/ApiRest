<?php
/**
 * Clase para establecer la conexión a la base de datos.
 */
class Conectar{
    /** @var PDO|null La conexión a la base de datos */
    protected $dbh;

    /**
     * Establece la conexión a la base de datos.
     * 
     * @return PDO La conexión establecida
     */
    protected function Conexion(){
        try{
            // Se establece la conexión utilizando PDO
            $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=andercode_webservice","root","");
            return $conectar;
        }catch(Exception $e){
            // En caso de error, se muestra el mensaje y se detiene el script
            print "¡Error BD: ".$e->getMessage(). "<br/>";
            die();
        }
    }

    /**
     * Establece el juego de caracteres de la conexión a UTF-8.
     * 
     * @return bool Retorna true si se establece correctamente, de lo contrario retorna false.
     */
    public function set_names(){
        // Se establece el juego de caracteres a UTF-8 para la conexión
        return $this->dbh->query("SET NAMES 'utf8'");
    }
}
?>
