<?php
//Para incluir una clase:
//include_once "Person.php";  Esta forma no detiene la ejecución, solo da warning
//require_once "Person.php";  Esto detiene la ejecución. Es mejor usar esta

class Person //extends Clase2 //implements INombreInterfaz
{
    public $nombre;
    protected $segSocial;
    private $pin;

    //Solo se permite un constructor aparte del por defecto
    function __construct($newNombre, $newSegSocial, $newPin)
    {
        $this->nombre = $newNombre;
        $this->segSocial = $newSegSocial;
        $this->pin = $newPin;
    }

    public function getNombre():string //:tipoDeDato para indicar qué devuelve, a partir de PHP 7
    {
        return $this->nombre;
    }

    public function setNombre($newNombre)
    {
        $this->nombre = $newNombre;
    }
}

//Para instanciar una clase:
$humano = new Person();

//Usamos el método setNombre
$humano->setNombre("Nose");

//Parecido a super en java:
parent::nombreMetodo();