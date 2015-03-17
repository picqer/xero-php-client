<?php

namespace Picqer\Xero;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class Xero
{
    private $endpoint = 'https://api.xero.com/api.xro/2.0';
    private $key;
    private $secret;
    private $privatekey = '../privatekey.pem';
    private $client;

    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;

        $this->prepareClient();
    }

    public function getContact($contactId)
    {
        $response = $this->requestGet('/contacts/' . $contactId);

        return Entities\BaseEntity::makeFromResponse('Contact', $response['Contacts'][0]);
    }

    private function prepareClient()
    {
        $client = new Client();
        $oauth = new Oauth1([
            'consumer_key'       => $this->key,
            'token'              => $this->key,
            'token_secret'       => $this->secret,
            'signature_method'   => Oauth1::SIGNATURE_METHOD_RSA,
            'consumer_secret'    => $this->getPrivateKeyPath()
        ]);

        $client->getEmitter()->attach($oauth);

        $this->client = $client;
    }

    private function request($method, $endpoint)
    {
        $request = $this->client->createRequest($method, $this->endpoint . $endpoint, ['auth' => 'oauth']);
        $request->addHeader('Accept', 'application/json');
        $response = $this->client->send($request);

        return $response;
    }

    private function requestGet($endpoint)
    {
        $response = $this->request('GET', $endpoint);

        $json = $response->json();

        return $json;
    }

    private function getPrivateKeyPath()
    {
        return __DIR__ . '/' . $this->privatekey;
    }
}