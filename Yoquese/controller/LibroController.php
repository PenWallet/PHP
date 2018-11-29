<?php

require_once "Controller.php";


class LibroController extends Controller
{
    public function manageGetVerb(Request $request)
    {
        $listaLibros = null;
        $id = null;
        $response = null;
        $code = null;

        //if the URI refers to a libro entity, instead of the libro collection
        if (isset($request->getUrlElements()[2])) {
            $id = $request->getUrlElements()[2];
        }

        $queryStrings = $request->getQueryString();

        $listaLibros = LibroHandlerModel::getLibro($id, $queryStrings);


        if ($listaLibros != null) {
            $code = '200';

        } else {

            //We could send 404 in any case, but if we want more precission,
            //we can send 400 if the syntax of the entity was incorrect...
            if (LibroHandlerModel::isValid($id)) {
                $code = '404';
            } else {
                $code = '400';
            }

        }

        $response = new Response($code, null, $listaLibros, $request->getAccept());

        $response->generate();

    }

    public function manageDeleteVerb(Request $request)
    {
        $id = null;
        $response = null;
        $code = null;

        //if the URI refers to a libro entity, instead of the libro collection
        if (isset($request->getUrlElements()[2])) {
            $id = $request->getUrlElements()[2];
        }

        $filasAfectadas = LibroHandlerModel::deleteLibro($id);

        if ($filasAfectadas == 1)
            $code = '200';
        else if($filasAfectadas == -2)
            $code = '404';
        else
            $code = '400';

        $response = new Response($code, null, null, $request->getAccept());
        $response->generate();
    }

    public function managePostVerb(Request $request)
    {
        $libro = (object)$request->getBodyParameters();

        $response = null;
        $code = null;

        $filasAfectadas = LibroHandlerModel::insertLibro($libro);

        if ($filasAfectadas)
            $code = '200';
        else
            $code = '400';

        $response = new Response($code, null, null, $request->getAccept());
        $response->generate();
    }

    public function managePutVerb(Request $request)
    {
        $libro = (object)$request->getBodyParameters();

        $response = null;
        $code = null;

        $filasAfectadas = LibroHandlerModel::updateLibro($libro);

        if ($filasAfectadas)
            $code = '200';
        else
            $code = '400';

        $response = new Response($code, null, null, $request->getAccept());
        $response->generate();
    }

}