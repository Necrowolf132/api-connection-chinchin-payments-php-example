
<?php

class OrderRequests
{
    private $baseUrl;

    /**
     *
     * @param string 
     */
    public function __construct(string $baseUrl)
    {
        $this->baseUrl = rtrim($baseUrl) . '/cmer/v1/order';
    }

    
    public function get(string $query,  array $headers = []): array
    {
        $url = $this->baseUrl . $query;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            return ['error' => $error];
        }

        return ['status' => $httpCode, 'response' => json_decode($response, true)];
    }

    public function post(array $body, array $headers = []): array
    {
        $url = $this->baseUrl;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);


        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $requestHeaders = curl_getinfo($ch, CURLINFO_HEADER_OUT);
        print_r("Imprimimos los Headers de la solicitud post con fines demostrativos\n");
        print_r($requestHeaders);
        print_r("\n");

        curl_close($ch);

        if ($error) {
            return ['error' => $error];
        }

        return ['status' => $httpCode, 'response' => json_decode($response, true)];
    }
}


