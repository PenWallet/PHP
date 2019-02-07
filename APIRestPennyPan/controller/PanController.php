<?php

require_once "Controller.php";


class PanController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $response = null;
        $code = null;

        $listaPanes = PanHandlerModel::getListadoPanes();

        if($listaPanes === false)
        {
            $listaPanes = null;
            $code = '500'; //Internal Server Error
        }
        else if($listaPanes == null)
            $code = '204';
        else
            $code = '200';

        $headers = array();
        if($request->getToken() != null)
            $headers["Authentication"] = "Bearer ".$request->getToken();

        $response = new Response($code, $headers, $listaPanes, $request->getAccept());
        $response->generate();

    }
}