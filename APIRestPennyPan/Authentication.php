<?php

require_once __DIR__."/JWT/JWT.php";
require_once __DIR__."/JWT/BeforeValidException.php";
require_once __DIR__."/JWT/SignatureInvalidException.php";
require_once __DIR__."/JWT/ExpiredException.php";
require_once __DIR__."/model/ClienteHandlerModel.php";
require_once "Request.php";

class Authentication
{
    const KEY = "UnaKeyTelaGuapaLocoPennyPanEsDIOS";

    public static function generateTokenFromLogin($cliente)
    {
        $time = time();

        $payload = array(
            'iat' => $time,
            'exp' => $time + 3600, //One hour until it expires
            'data' => [
                'username' => $cliente->getUsername(),
                'nombre' => $cliente->getNombre(),
                'panadero' => $cliente->getPanadero()
            ]
        );

        return JWT::encode($payload, self::KEY);
    }

    /**
     * Devuelve -1 si el token ha expirado, -2 si el token aún no es válido, o -3 si falló la autentificación de la firma
     * @param $token
     * @return int o payload del token
     */
    public static function getPayloadFromToken($token)
    {
        try{
            $payload = JWT::decode($token, self::KEY, array('HS256'));
        }catch (ExpiredException $e) { $payload = false; }
        catch (BeforeValidException $e) { $payload = false; }
        catch (SignatureInvalidException $e ) { $payload = false; }
        catch (UnexpectedValueException $e ) { $payload = false; }
        catch (Exception $e ) { $payload = false; }

        return $payload;
    }

    /**
     * Devuelve un nuevo token si la autentificación ha sido correcta, o false en caso contrario
     * @param $req
     * @return string o false
     */
    public static function isAuthenticated(Request $req)
    {
        $token = $req->getToken();
        $authUser = $req->getAuthUser();
        $authPass = $req->getAuthPass();

        if($token != null)
        {
            $payload = self::getPayloadFromToken($token);
            if($payload === false)
                return false;
            else
            {
                $data = $payload->data;
                return self::generateTokenFromLogin(new ClienteModel($data->username, null, $data->nombre, $data->panadero));
            }
        }
        else if($authPass != null && $authUser != null)
        {
            $cliente = ClienteHandlerModel::getUsuario($authUser, $authPass);
            if($cliente == null)
                return false;
            else
                return self::generateTokenFromLogin($cliente);
        }
        else
            return false;

    }

    public static function hasUserPermission($request)
    {
        $hasPermission = false;
        $verb = $request->getVerb();
        $urlElements = $request->getUrlElements();
        $controller = isset($urlElements[3]) ? ucfirst($urlElements[3]) : ucfirst($urlElements[1]);


        if($controller == "Pan" || $controller == "Complemento" || $controller == "Ingrediente" || ($verb == "POST" && $controller == "Cliente"))
            $hasPermission = true;
        else
        {
            $payload = self::getPayloadFromToken($request->getToken());

            if($payload !== false)
            {
                //Si está intentando editar un cliente o si está intentando obtener todo el listado de clientes
                if($controller == "Cliente" && $verb == "PUT" || $controller == "Cliente" && $verb == "GET" && !isset($urlElements[2]))
                {
                    $panadero = $payload->data->panadero;

                    if($panadero == 1)
                        $hasPermission = true;
                }
                else
                    $hasPermission = true;
            }
        }

        return $hasPermission;
    }

}