<?php

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 18/12/18
 * Time: 9:40
 */
class UsuarioModel implements JsonSerializable
{
    private $username;
    private $contrasena;
    private $nombre;
    private $apellidos;
    private $fechaNac;
    private $ciudad;
    private $direccion;
    private $telefono;

    /**
     * UsuarioModel constructor.
     * @param $username
     * @param $contrasena
     * @param $nombre
     * @param $apellidos
     * @param $fechaNac
     * @param $ciudad
     * @param $direccion
     * @param $telefono
     */
    public function __construct($username, $contrasena, $nombre, $apellidos, $fechaNac, $ciudad, $direccion, $telefono)
    {
        $this->username = $username;
        $this->contrasena = $contrasena;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fechaNac = $fechaNac;
        $this->ciudad = $ciudad;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return mixed
     */
    public function getFechaNac()
    {
        return $this->fechaNac;
    }

    /**
     * @param mixed $fechaNac
     */
    public function setFechaNac($fechaNac)
    {
        $this->fechaNac = $fechaNac;
    }

    /**
     * @return mixed
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * @param mixed $ciudad
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getContrasena()
    {
        return $this->contrasena;
    }

    //JSON Serializable
    function jsonSerialize()
    {
        return array(
            'username' => $this->username,
            'contrasena' => $this->contrasena,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'fechaNac' => $this->fechaNac,
            'ciudad' => $this->ciudad,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono
        );
    }

    public function __sleep(){
        return array('username', 'contrasena', 'nombre' , 'apellidos', 'fechaNac', 'ciudad', 'direccion', 'telefono');
    }


}