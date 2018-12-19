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
        $listadoUsuarios = null;

        if(isset($request->getUrlElements()[2]))
        {
            $username = $request->getUrlElements()[2];

            if($authUser != null && $authPass != null && $authUser == $username) {

                $listadoUsuarios = ClienteHandlerModel::getUsuario($authUser, $authPass);

                if($listadoUsuarios == null)
                    $code = '401'; //Unauthorized
                else
                    $code = '200'; //OK

            }
            else {
                $code = '400'; //Bad Request
            }
        }
        else
        {
            if ($authUser != null && $authPass != null) {

                $panadero = ClienteHandlerModel::getUsuario($authUser, $authPass);

                $listadoUsuarios = ClienteHandlerModel::getListadoUsuarios($panadero);

                if ($listadoUsuarios != null)
                {
                    //Get listado de usuarios
                }
                else
                    $code = '401'; //Unauthorized
            }
        }



        $response = new Response($code, null, $listadoUsuarios, $request->getAccept());
        $response->generate();

    }

}