<?php

require_once "Controller.php";

class UnauthorizedController extends Controller
{
    public function manage($req)
    {
        $response = new Response('401', null, null, $req->getAccept());
        $response->generate();
    }

}