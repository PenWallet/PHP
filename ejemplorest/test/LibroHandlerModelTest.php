<?php

require_once "../model/LibroHandlerModel.php";
require_once "../model/LibroModel.php";

$listadoLibros = LibroHandlerModel::getLibro(null);

foreach ($listadoLibros as $libroAr)
{
    echo $libroAr->getTitulo();
}

/*
$libro = new LibroModel(0, "PruebaPHP", 190);

$insertado = LibroHandlerModel::insertLibro($libro);

echo "¿Se ha insertado?: ".$insertado;*/