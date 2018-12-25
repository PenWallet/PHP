<?php

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 18/12/18
 * Time: 9:40
 */
class IngredienteBocataModel extends IngredienteModel implements JsonSerializable
{
    private $cantidad;

    /**
     * ComplementoPedidoModel constructor.
     * @param $id
     * @param $nombre
     * @param $precio
     * @param $cantidad
     */
    public function __construct($id, $nombre, $precio, $cantidad)
    {
        parent::__construct($id, $nombre, $precio);
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
            'precio' => $this->getPrecio(),
            'cantidad' => $this->cantidad
        );
    }

    public function __sleep(){
        return array('id', 'nombre', 'precio', 'cantidad');
    }


}