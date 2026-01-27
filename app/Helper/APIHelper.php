<?php
namespace App\Helper;

class APIHelper
{

    public function apiCall($method, $url, $body) {
        $fixheaders = [
            'Content-Type' => 'application/json',
        ];
        $client = new \GuzzleHttp\Client([
            'headers' => $fixheaders
        ]);
        $res = $client->request($method, $url, [
            'body' => $body
        ]);
        $response = $res->getBody()->getContents();
        return $response;
    }

    public function httpCall($method, $url, $body, $headers) {
        $fixheaders = [
            'Content-Type' => 'application/json',
        ];
        $client = new \GuzzleHttp\Client([
            'headers' => $fixheaders
        ]);
        $res = $client->request($method, $url, [
            'form_params' => $body
        ]);
        $response = $res->getBody()->getContents();
        return $response;
    }

    public function httpCallJson($method, $url, $body, $headers) {
        $fixheaders = [
            'Content-Type' => 'application/json',
        ];
        $client = new \GuzzleHttp\Client([
            'headers' => $fixheaders
        ]);
        $res = $client->request($method, $url, [
            'body' => json_encode($body),
        ]);
        $response = $res->getBody()->getContents();
        return $response;
    }

    public static function instance()
    {
        return new APIHelper();
    }

}