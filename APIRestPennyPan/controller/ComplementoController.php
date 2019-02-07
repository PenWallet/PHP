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

        $headers = array();
        if($request->getToken() != null)
            $headers["Authentication"] = "Bearer ".$request->getToken();


        $response = new Response($code, $headers, $listaComplementos, $request->getAccept());
        $response->generate($request->getToken());
    }
}