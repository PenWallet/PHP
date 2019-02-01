<?php

namespace model;
use Firebase\JWT\JWT;

class TokenHandlerModel
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

    public static function getPayloadFromToken($token)
    {
        \Firebase\JWT\JWT::decode($token, self::KEY);
    }

}