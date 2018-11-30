<?php

require_once "Controller.php";


class CapituloController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $listaCapitulos = null;
        $idCap = null;
        $idLib = null;
        $response = null;
        $code = null;

        //if the URI refers to a libro entity, instead of the libro collection
        if (isset($request->getUrlElements()[2])) {
            $idLib = $request->getUrlElements()[2];
        }

        if (isset($request->getUrlElements()[4])) {
            $idCap = $request->getUrlElements()[4];
        }


        $listaCapitulos = CapituloHandlerModel::getCapitulo($idLib, $idCap);

        if ($listaCapitulos != null) {
            $code = '200';

        } else {

            //We could send 404 in any case, but if we want more precission,
            //we can send 400 if the syntax of the entity was incorrect...
            if (CapituloHandlerModel::isValid($idCap) && CapituloHandlerModel::isValid($idLib) && (!CapituloHandlerModel::idCapituloExists($idLib, $idCap) || !CapituloHandlerModel::idLibroExists($idLib))){
                $code = '404';
            } else {
                $code = '400';
            }

        }

        $response = new Response($code, null, $listaCapitulos, $request->getAccept());
        $response->generate();

    }

}