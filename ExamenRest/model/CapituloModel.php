<?php


class CapituloModel implements JsonSerializable
{
    private $codigoLibro;
    private $capitulo;
    private $titulo;
    private $pagPrinc;
    private $pagFinal;

    public function __construct($id,$codigoLibro,$titulo,$pagPrinc,$pagFinal)
    {
        $this->capitulo=$id;
        $this->codigoLibro=$codigoLibro;
        $this->titulo=$titulo;
        $this->pagPrinc=$pagPrinc;
        $this->pagFinal=$pagFinal;

    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */

    //Needed if the properties of the class are private.
    //Otherwise json_encode will encode blank objects
    function jsonSerialize()
    {
        return array(
            'capitulo' => $this->capitulo,
            'codigoLibro' => $this->codigoLibro,
            'titulo' => $this->titulo,
            'pagPrinc' => $this->pagPrinc,
            'pagFinal' => $this->pagFinal
        );
    }

    public function __sleep(){
        return array('capitulo' , 'codigoLibro' , 'titulo' , 'pagPrinc' , 'pagFinal');
    }

    /**
     * @return mixed
     */
    public function getCapitulo()
    {
        return $this->capitulo;
    }

    /**
     * @param mixed $capitulo
     */
    public function setCapitulo($capitulo)
    {
        $this->capitulo = $capitulo;
    }

    /**
     * @return mixed
     */
    public function getCodigoLibro()
    {
        return $this->codigoLibro;
    }

    /**
     * @param mixed $codigoLibro
     */
    public function setCodigoLibro($codigoLibro)
    {
        $this->codigoLibro = $codigoLibro;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getPagPrinc()
    {
        return $this->pagPrinc;
    }

    /**
     * @param mixed $pagPrinc
     */
    public function setPagPrinc($pagPrinc)
    {
        $this->pagPrinc = $pagPrinc;
    }

    /**
     * @return mixed
     */
    public function getPagFinal()
    {
        return $this->pagFinal;
    }

    /**
     * @param mixed $pagFinal
     */
    public function setPagFinal($pagFinal)
    {
        $this->pagFinal = $pagFinal;
    }

}