<?php
require_once "../Database.php";

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 26/10/18
 * Time: 8:35
 */
class Pan
{
    public static function listaPanes()
    {
        $sentencia = null;
        $array = array();
        $database = Database::getInstance();
        $conexion = $database->getConnection();

        if($conexion->connect_error)
        {
            trigger_error("Error al conectar a MySQL".$conexion->connect_error, E_USER_ERROR);
        }
        else
        {
            if($sentencia = $conexion->prepare("SELECT ID, Nombre FROM Panes"))
            {
                $sentencia->execute();
            }
        }

        $sentencia->bind_result($id, $nombre);

        while($sentencia->fetch())
        {
            $array[$id] = $nombre;
        }

        $database->closeConnection();


        return $array;
    }

    /*
    private $id;
    public $nombre;
    public $crujenticidad;
    public $esIntegral;
    public $precio;

    function __construct($newID, $newNombre, $newCrujenticidad, $newIntegral, $newPrecio)
    {
        $this->id = $newID;
        $this->nombre = $newNombre;
        $this->crujenticidad = $newCrujenticidad;
        $this->esIntegral = $newIntegral;
        $this->precio = $newPrecio;
    }

    public function getID(){return $this->id;}
    public function setID($newID){ $this->id = $newID; }

    public function getNombre(){ return $this->nombre; }
    public function setNombre($newNombre){ $this->nombre = $newNombre; }

    public function getCrujenticidad(){ return $this->crujenticidad; }
    public function setCrujenticidad($newCrujenticidad){ $this->crujenticidad = $newCrujenticidad; }

    public function getEsIntegral(){ return $this->esIntegral; }
    public function setEsIntegral($newIntegral){ $this->esIntegral = $newIntegral; }

    public function getPrecio(){ return $this->precio; }
    public function setPrecio($newPrecio){ $this->precio = $newPrecio; }*/


}