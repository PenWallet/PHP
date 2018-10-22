<?php

/**
 * Created by PhpStorm.
 * User: ofunes
 * Date: 15/10/18
 * Time: 10:13
 */
class Palabra
{
    private $texto;

    public function __construct($newTexto)
    {
        $this->texto = $newTexto;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function setTexto($newTexto)
    {
        $this->texto = $newTexto;
    }

    public function contarPalabra($palabra)
    {
        $cont = 0;
        $palabras = preg_split('/\s+/', $this->texto);
        for ($x = 0; $x < count($palabras); $x++)
        {
            if($palabras[$x] == $palabra)
                $cont++;
        }

        return $cont;
    }

    public function posicionPalabra($palabra)
    {
        $arrayPosiciones = array();
        $palabras = preg_split('/\s+/', $this->texto);
        for ($x = 0; $x < count($palabras); $x++)
        {
            if($palabras[$x] == $palabra)
                array_push($arrayPosiciones, $x+1);
        }

        return $arrayPosiciones;
    }

    public function sustituirPalabra($palabraVieja, $palabraNueva)
    {
        $palabras = preg_split('/\s+/', $this->texto);
        for($x = 0; $x < count($palabras); $x++)
        {
            if($palabras[$x] == $palabraVieja)
                $palabras[$x] = $palabraNueva;
        }

        return implode(" ", $palabras);
    }

    public function intercambiarPalabras($pos1, $pos2)
    {
        $palabras = preg_split('/\s+/', $this->texto);
        if(count($palabras) >= $pos1 && count($palabras) >= $pos2 && $pos1 != $pos2)
        {
            $palabra1 = $palabras[$pos1];
            $palabras[$pos1] = $palabras[$pos2];
            $palabras[$pos2] = $palabra1;
        }

        return implode(" ", $palabras);
    }
}
