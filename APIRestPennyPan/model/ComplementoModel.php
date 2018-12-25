<?php

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 18/12/18
 * Time: 9:40
 */
class ComplementoModel implements JsonSerializable
{
    private $id;
    private $nombre;
    private $precio;

    /**
     * ComplementoModel constructor.
     * @param $id
     * @param $nombre
     * @param $precio
     */
    public function __construct($id, $nombre, $precio)
    {
        $this->id = $id;
        $this->nombre = $nombre;
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
            'precio' => $this->precio
        );
    }

    public function __sleep(){
        return array('id', 'nombre', 'precio');
    }


}