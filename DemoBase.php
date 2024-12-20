<?php
require './Auth.php'; 
require './OrderResquests.php'; 

// Ejemplo de uso:
// URL base de la API en este caso la suya es.
$baseUrl = "https://sandbox-gprd.pagochinchin.com";

// Crear instancia de las clases de consulta para ordenes con los metodos, post y get, y ademas instanciar la clases Auth para poder firmar las peticiones.
$orderRequests = new OrderRequests($baseUrl);
$authInstance = new Authentication("Your apiSecretKey provided", "Your apiPublicKey provided");
//example 
//$authInstance = new Authentication("xxxxb01810ed9b97510c0c0c81f5xxx", "xxxxf430202a5153e7e9dcc341bxxxx");


// Hacer una solicitud POST.
$postBody = [
    "idMembership" => "Your membership id provided",
    // example
    //"idMembership" => "xx68594a9954eee09a91eexxx",
    "externalReference" => "ORDEN-123456",
    "clientOwner" => "J413198282",
    "amount" => 10.00,
    "currency" => "BS",
    "expirationMs" => 1200000,
    "showItems" => true,
    "payingUser" => [
        "firstName" => "prueba",
        "secondName" => "prueba",
        "lastname" => "prueba",
        "surname" => "prueba",
        "email" => "prueba@gmail.com",
        "phoneNumberCode" => "3524",
        "phoneNumber" => "490523",
        "documentId" => "V145234253"
    ],
    //"deliverProfitsTo" => [
    //    [
    //        "username" => "beto2102",
    //        "tagTypePaid" => "FIXED",
    //        "value" => "10"
    //    ]
    //],
    "items" => [
        [
            "name" => "sushi",
            "image" => "https://s1.eestatic.com/2021/05/27/como/584453709_186431572_1706x960.jpg",
            "description" => "sushi",
            "quantity" => "2",
            "price" => "5",
            "totalPrice" => "10"
        ]
    ],
    "metadata" => [
        "prueba" => "Esto es una prueba de metadata"
    ],
    "successUrl" => "https://www.pagochinchin.com/success",
    "returnUrl" => "https://www.pagochinchin.com/back",
    "errorUrl" => "https://www.pagochinchin.com/error"
];
print("Ejemplo de consulta post (Respuesta)\n");
$postResponse = $orderRequests->post($postBody, $authInstance->signRequest('/cmer/v1/order', $postBody));
print_r($postResponse);

print("Ejemplo de consulta get (Respuesta)\n");
// En esta consulta se pasa como parametro el OrderID que se genero en el paso previo por medio de la consulta post tanto como parametro de la query como tambien como parametro,
// de la funcion de firma 
$postResponse = $orderRequests->get("?idOrder=67656be1f6d9dc8c2d397cb7", $authInstance->signRequest('/cmer/v1/order',["idOrder"=>"67656be1f6d9dc8c2d397cb7"]));
print_r($postResponse);