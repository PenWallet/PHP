<?php

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 18/12/18
 * Time: 9:40
 */
class PanModel implements JsonSerializable
{
    private $id;
    private $nombre;
    private $crujenticidad;
    private $integral;
    private $precio;

    /**
     * PanModel constructor.
     * @param $id
     * @param $nombre
     * @param $crujenticidad
     * @param $integral
     * @param $precio
     */
    public function __construct($id, $nombre, $crujenticidad, $integral, $precio)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->crujenticidad = $crujenticidad;
        $this->integral = $integral;
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getCrujenticidad()
    {
        return $this->crujenticidad;
    }

    /**
     * @param mixed $crujenticidad
     */
    public function setCrujenticidad($crujenticidad)
    {
        $this->crujenticidad = $crujenticidad;
    }

    /**
     * @return mixed
     */
    public function getIntegral()
    {
        return $this->integral;
    }

    /**
     * @param mixed $integral
     */
    public function setIntegral($integral)
    {
        $this->integral = $integral;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    //JSON Serializable
    function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'nombre' => $this->nombre,
            'crujenticidad' => $this->crujenticidad,
            'integral' => $this->integral,
            'precio' => $this->precio
        );
    }

    public function __sleep(){
        return array('id', 'nombre', 'crujenticidad', 'integral', 'precio');
    }


}