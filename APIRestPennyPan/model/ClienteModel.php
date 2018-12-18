<?php

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 18/12/18
 * Time: 9:40
 */
class ClienteModel implements JsonSerializable
{
    private $username;
    private $contrasena;
    private $nombre;
    private $panadero;

    /**
     * ClienteModel constructor.
     * @param $username
     * @param $contrasena
     * @param $nombre
     * @param $panadero
     */
    public function __construct($username, $contrasena, $nombre, $panadero)
    {
        $this->username = $username;
        $this->contrasena = $contrasena;
        $this->nombre = $nombre;
        $this->panadero = $panadero;
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
    public function getContrasena()
    {
        return $this->contrasena;
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
    public function getPanadero()
    {
        return $this->panadero;
    }

    /**
     * @param mixed $panadero
     */
    public function setPanadero($panadero)
    {
        $this->panadero = $panadero;
    }



    //JSON Serializable
    function jsonSerialize()
    {
        return array(
            'username' => $this->username,
            'contrasena' => $this->contrasena,
            'nombre' => $this->nombre,
            'panadero' => $this->panadero
        );
    }

    public function __sleep(){
        return array('username', 'contrasena', 'nombre' , 'panadero');
    }


}