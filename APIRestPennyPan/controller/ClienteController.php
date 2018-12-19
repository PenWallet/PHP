<?php

require_once "Controller.php";


class ClienteController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $response = null;
        $code = null;
        $authUser = $request->getAuthUser();
        $authPass = $request->getAuthPass();
        $usuario = null;

        if(isset($request))

        if($authUser != null && $authPass != null) {

         $usuario = ClienteHandlerModel::getUsuario($authUser, $authPass);

            if($usuario == null)
                $code = '401'; //Unauthorized
            else
                $code = '200';

        }
        else{
            $code = '400'; //Bad Request
        }

        $response = new Response($code, null, $usuario, $request->getAccept());
        $response->generate();

    }

}