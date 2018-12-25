<?php

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 18/12/18
 * Time: 9:40
 */
class PanPedidoModel extends PanModel implements JsonSerializable
{
    private $cantidad;

    /**
     * PanPedidoModel constructor.
     * @param $id
     * @param $nombre
     * @param $crujenticidad
     * @param $integral
     * @param $precio
     * @param $cantidad
     */
    public function __construct($id, $nombre, $crujenticidad, $integral, $precio, $cantidad)
    {
        parent::__construct($id, $nombre, $crujenticidad, $integral, $precio);
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    //JSON Serializable
    function jsonSerialize()
    {
        return array(
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'crujenticidad' => $this->getCrujenticidad(),
            'integral' => $this->getIntegral(),
            'precio' => $this->getPrecio(),
            'cantidad' => $this->cantidad
        );
    }

    public function __sleep(){
        return array('id', 'nombre', 'crujenticidad', 'integral', 'precio', 'cantidad');
    }


}