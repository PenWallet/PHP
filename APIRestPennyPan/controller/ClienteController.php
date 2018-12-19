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
        $username = null;
        $usuario = null;

        if(isset($request->getUrlElements()[2]))
        {
            $username = $request->getUrlElements()[2];

            if($authUser != null && $authPass != null && $authUser == $username) {

                $usuario = ClienteHandlerModel::getUsuario($authUser, $authPass);

                if($usuario == null)
                    $code = '401'; //Unauthorized
                else
                    $code = '200'; //OK

            }
            else{
                $code = '400'; //Bad Request
            }
        }
        else
        {
            $code = '501'; //Not implemented
        }



        $response = new Response($code, null, $usuario, $request->getAccept());
        $response->generate();

    }

}