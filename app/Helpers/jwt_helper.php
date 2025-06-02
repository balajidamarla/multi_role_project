<?php 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function decodeJWT($token)
{
    $key = getenv('JWT_SECRET') ?: '53880c2242452df2161c7c818dc4c2c1f19aedfbf4d7762866f5c5e3fa742c54';
    return JWT::decode($token, new Key($key, 'HS256'));
}
