<?php

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 18/12/18
 * Time: 9:40
 */
class PedidoModel implements JsonSerializable
{
    private $id;
    private $fechaCompra;
    private $importeTotal;
    private $bocatas;
    private $panes;
    private $complementos;

    /**
     * PedidoModel constructor.
     * @param $id
     * @param $fechaCompra
     * @param $importeTotal
     * @param $bocatas
     * @param $panes
     * @param $complementos
     */
    public function __construct($id, $fechaCompra, $importeTotal, $bocatas, $panes, $complementos)
    {
        $this->id = $id;
        $this->fechaCompra = $fechaCompra;
        $this->importeTotal = $importeTotal;
        $this->bocatas = $bocatas;
        $this->panes = $panes;
        $this->complementos = $complementos;
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
    public function getFechaCompra()
    {
        return $this->fechaCompra;
    }

    /**
     * @param mixed $fechaCompra
     */
    public function setFechaCompra($fechaCompra)
    {
        $this->fechaCompra = $fechaCompra;
    }

    /**
     * @return mixed
     */
    public function getImporteTotal()
    {
        return $this->importeTotal;
    }

    /**
     * @param mixed $importeTotal
     */
    public function setImporteTotal($importeTotal)
    {
        $this->importeTotal = $importeTotal;
    }

    /**
     * @return mixed
     */
    public function getBocatas()
    {
        return $this->bocatas;
    }

    /**
     * @param mixed $bocatas
     */
    public function setBocatas($bocatas)
    {
        $this->bocatas = $bocatas;
    }

    /**
     * @return mixed
     */
    public function getPanes()
    {
        return $this->panes;
    }

    /**
     * @param mixed $panes
     */
    public function setPanes($panes)
    {
        $this->panes = $panes;
    }

    /**
     * @return mixed
     */
    public function getComplementos()
    {
        return $this->complementos;
    }

    /**
     * @param mixed $complementos
     */
    public function setComplementos($complementos)
    {
        $this->complementos = $complementos;
    }

    //JSON Serializable
    function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'fechaCompra' => $this->fechaCompra,
            'importeTotal' => $this->importeTotal,
            'bocatas' => $this->bocatas,
            'panes' => $this->panes,
            'complementos' => $this->complementos
        );
    }

    public function __sleep(){
        return array('id', 'fechaCompra', 'importeTotal' , 'bocatas', 'panes', 'complementos');
    }


}