<?php

require_once __DIR__."/JWT/JWT.php";

class Tokens
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
            $payload = \Firebase\JWT\JWT::decode($token, self::KEY);
        }catch (\Firebase\JWT\ExpiredException $e) { $payload = -1; }
        catch (\Firebase\JWT\BeforeValidException $e) { $payload = -2; }
        catch ( \Firebase\JWT\SignatureInvalidException $e ) { $payload = -3; }

        return $payload;
    }

}