<?php
require_once "../Database.php";

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 26/10/18
 * Time: 8:44
 */
class Cliente
{
    public static function listaClientes()
    {
        $sentencia = null;
        $array = array();
        $nombreCompleto = null;
        $database = Database::getInstance();
        $conexion = $database->getConnection();

        if($conexion->connect_error)
        {
            trigger_error("Error al conectar a MySQL".$conexion->connect_error, E_USER_ERROR);
        }
        else
        {
            if($sentencia = $conexion->prepare("SELECT ID, Nombre, Apellidos FROM Clientes"))
            {
                $sentencia->execute();
            }
        }

        $sentencia->bind_result($id, $nombre, $apellidos);

        while($sentencia->fetch())
        {
            $nombreCompleto = $nombre." ".$apellidos;
            $array[$id] = $nombreCompleto;
        }

        $database->closeConnection();


        return $array;
    }

    /*private $id;
    public $nombre;
    public $apellidos;
    public $fechaNac;
    public $ciudad;
    public $direccion;
    public $telefono;

    function __construct($newID, $newNombre, $newApellidos, $newFechaNac, $newCiudad, $newDireccion, $newTelefono)
    {
        $this->id = $newID;
        $this->nombre = $newNombre;
        $this->apellidos = $newApellidos;
        $this->fechaNac = $newFechaNac;
        $this->ciudad = $newCiudad;
        $this->direccion = $newDireccion;
        $this->telefono = $newTelefono;
    }

    public function getID(){ return $this->id; }
    public function setID($newID){ $this->id = $newID; }

    public function getNombre(){ return $this->nombre; }
    public function setNombre($newNombre){ $this->nombre = $newNombre; }

    public function getApellidos(){ return $this->apellidos; }
    public function setApellidos($newApellidos){ $this->apellidos = $newApellidos; }

    public function getFechaNac(){ return $this->fechaNac; }
    public function setFechaNacl($newFechaNac){ $this->fechaNac = $newFechaNac; }

    public function getCiudad(){ return $this->ciudad; }
    public function setCiudad($newCiudad){ $this->ciudad = $newCiudad; }

    public function getDireccion(){ return $this->direccion; }
    public function setDireccion($newDireccion){ $this->direccion = $newDireccion; }

    public function getTelefono(){ return $this->telefono; }
    public function setTelefono($newTelefono){ $this->telefono = $newTelefono; }*/
}