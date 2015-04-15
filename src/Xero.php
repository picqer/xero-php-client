<?php

namespace Picqer\Xero;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Stream\Stream;

class Xero {
    private $endpoint = 'https://api.xero.com/api.xro/2.0';
    private $key;
    private $secret;
    private $privatekey = '../privatekey.pem';

    /**
     * @var Client
     */
    private $client;

    public function __construct($key, $secret, $privateKeyPath = null)
    {
        $this->key = $key;
        $this->secret = $secret;

        if ( ! is_null($privateKeyPath))
            $this->privatekey = $privateKeyPath;

        $this->prepareClient();
    }

    public function getContact($contactId)
    {
        $response = $this->requestGet('/contacts/' . $contactId);

        return Entities\BaseEntity::makeFromResponse('Contact', $response['Contacts'][0]);
    }

    public function getContacts()
    {
        $response = $this->requestGet('/contacts');

        return Entities\BaseEntity::makeCollectionFromResponse('Contact', $response['Contacts']);
    }

    public function getInvoice($invoiceId)
    {
        $response = $this->requestGet('/invoices/' . $invoiceId);

        return Entities\BaseEntity::makeFromResponse('Invoice', $response['Invoices'][0]);
    }

    public function getInvoices()
    {
        $response = $this->requestGet('/invoices');

        return Entities\BaseEntity::makeCollectionFromResponse('Invoice', $response['Invoices']);
    }

    public function create(Entities\BaseEntity $entity)
    {
        $xmlBuilder = new XmlBuilder();
        $xml = $xmlBuilder->build($entity);

        $response = $this->requestPut($entity->getEndpoint(), $xml);

        return $response;
    }

    public function update(Entities\BaseEntity $entity)
    {
        $xmlBuilder = new XmlBuilder();
        $xml = $xmlBuilder->build($entity);

        $response = $this->requestPost($entity->getEndpoint() . '/' . $entity->getPrimaryKeyValue(), $xml);

        return $response;
    }

    private function prepareClient()
    {
        $client = new Client();
        $oauth = new Oauth1([
            'consumer_key'     => $this->key,
            'token'            => $this->key,
            'token_secret'     => $this->secret,
            'signature_method' => Oauth1::SIGNATURE_METHOD_RSA,
            'consumer_secret'  => $this->getPrivateKeyPath()
        ]);

        $client->getEmitter()->attach($oauth);

        $this->client = $client;
    }

    private function request($method, $endpoint, $data = null)
    {
        $request = $this->client->createRequest(
            $method,
            $this->endpoint . $endpoint,
            [
                'auth'   => 'oauth',  // Use oauth plugin
                'verify' => __DIR__ . '/../ca-bundle.crt' // Needed for Xero's old certificates
            ]
        );
        $request->addHeader('Accept', 'application/json');

        if ( ! is_null($data))
        {
            $request->setBody(Stream::factory($data));
        }
        $response = $this->client->send($request);

        return $response;
    }

    private function requestGet($endpoint)
    {
        $response = $this->request('GET', $endpoint);

        $json = $response->json();

        return $json;
    }

    private function requestPost($endpoint, $xml)
    {
        $response = $this->request('POST', $endpoint, $xml);

        $json = $response->json();

        return $json;
    }

    private function requestPut($endpoint, $xml)
    {
        $response = $this->request('PUT', $endpoint, $xml);

        $json = $response->json();

        return $json;
    }

    private function getPrivateKeyPath()
    {
        if (substr($this->privatekey, 0, 1) != '/')
            return __DIR__ . '/' . $this->privatekey;

        return $this->privatekey;
    }
}