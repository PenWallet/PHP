<?php

require_once "Controller.php";
require_once dirname(__DIR__)."/Tokens.php";



class LoginController extends Controller
{
    public function managePostVerb(Request $request)
    {
        $code = null;
        $headers = null;

        //if()

        $response = new Response($code, null, null, $request->getAccept());
        $response->generate();

    }

}