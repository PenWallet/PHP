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


        $response = new Response($code, null, $listaPanes, $request->getAccept());
        $response->generate();

    }
}