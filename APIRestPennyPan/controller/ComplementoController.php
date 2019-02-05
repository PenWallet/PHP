<?php

require_once "Controller.php";


class ComplementoController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $response = null;
        $code = null;

        $listaComplementos = ComplementoHandlerModel::getListadoComplementos();

        if($listaComplementos === false)
        {
            $listaComplementos = null;
            $code = '500'; //Internal Server Error
        }
        else if($listaComplementos == null)
            $code = '204';
        else
            $code = '200';


        $response = new Response($code, null, $listaComplementos, $request->getAccept());
        $response->generate($request->getToken());
    }
}