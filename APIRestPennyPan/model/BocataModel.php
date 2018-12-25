<?php

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 18/12/18
 * Time: 9:40
 */
class BocataModel implements JsonSerializable
{
    private $pan;
    private $ingredientes;

    /**
     * ClienteModel constructor.
     * @param $pan
     * @param $ingredientes
     */
    public function __construct($pan, $ingredientes)
    {
        $this->pan = $pan;
        $this->ingredientes = $ingredientes;
    }

    /**
     * @return mixed
     */
    public function getPan()
    {
        return $this->pan;
    }

    /**
     * @param mixed $pan
     */
    public function setPan($pan)
    {
        $this->pan = $pan;
    }

    /**
     * @return mixed
     */
    public function getIngredientes()
    {
        return $this->ingredientes;
    }

    /**
     * @param mixed $ingredientes
     */
    public function setIngredientes($ingredientes)
    {
        $this->ingredientes = $ingredientes;
    }

    //JSON Serializable
    function jsonSerialize()
    {
        return array(
            'pan' => $this->pan,
            'ingredientes' => $this->ingredientes
        );
    }

    public function __sleep(){
        return array('pan', 'ingredientes');
    }


}