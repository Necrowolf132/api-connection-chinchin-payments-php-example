<?php

class Authentication
{
    private $apiSecretKey;
    private $apiPublicKey;

    /**
     * Constructor para inicializar las claves.
     *
     * @param string $apiSecretKey Clave secreta para firmar.
     * @param string $apiPublicKey Clave pública para el encabezado.
     */
    public function __construct(string $apiSecretKey, string $apiPublicKey)
    {
        $this->apiSecretKey = $apiSecretKey;
        $this->apiPublicKey = $apiPublicKey;
    }

    /**
     * Genera una firma para un path dado con un cuerpo específico.
     *
     * @param string $path Ruta del recurso o servicio.
     * @param array $body Datos del cuerpo de la solicitud.
     * @return array Encabezados con la firma generada.
     */
    public function signRequest(string $path, array $body): array
    {
        // Generar un nonce único basado en el tiempo actual.
        $nonce = (int)(microtime(true) * 1000);

        // Convertir el cuerpo a formato JSON.
        $bodyJson = empty($body) ? "" : json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        echo "aqui Json \n";
        print_r($bodyJson);
        print_r("\n");

        // Crear la cadena para firmar todo concatenado.
        $signatureString = $path . $nonce . $bodyJson;

        // Generar la firma utilizando HMAC-SHA384.
        $signature = hash_hmac('sha384', $signatureString, $this->apiSecretKey);

        // Devolver los encabezados con la firma.
        return [
            "api-key:".$this->apiPublicKey,
            "api-nonce:".$nonce,
            "api-signature:".$signature,
            "Content-Type:application/json",
        ];
    }
}


