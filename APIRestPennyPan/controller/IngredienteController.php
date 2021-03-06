<?php

require_once "Controller.php";


class IngredienteController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $response = null;
        $code = null;

        $listaIngredientes = IngredienteHandlerModel::getListadoIngredientes();

        if($listaIngredientes === false)
        {
            $listaIngredientes = null;
            $code = '500'; //Internal Server Error
        }
        else if($listaIngredientes == null)
            $code = '204';
        else
            $code = '200';

        $headers = array();
        if($request->getToken() != null)
            $headers["Authentication"] = "Bearer ".$request->getToken();

        $response = new Response($code, $headers, $listaIngredientes, $request->getAccept());
        $response->generate();

    }
}