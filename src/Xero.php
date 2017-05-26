<?php

namespace Picqer\Xero;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Psr7\Response;
use Picqer\Xero\Exceptions\XeroApiException;
use Picqer\Xero\Exceptions\XeroRatelimitExceededException;

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

    public function getInvoicePdf($invoiceId)
    {
        $endpoint = '/invoices/' . $invoiceId;

        $response = $this->request('get', $endpoint, null, 'application/pdf');

        return $response->getBody()->getContents();
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
        $stack = HandlerStack::create();

        $oauth = new Oauth1([
            'consumer_key'     => $this->key,
            'token'            => $this->key,
            'token_secret'     => $this->secret,
            'signature_method' => Oauth1::SIGNATURE_METHOD_RSA,
            'private_key_file'  => $this->getPrivateKeyPath(),
            'private_key_passphrase' => ''
        ]);
        $stack->push($oauth);

        $this->container = [];
        $history = Middleware::history($this->container);
        $stack->push($history);

        $client = new Client([
            'handler' => $stack
        ]);

        $this->client = $client;
    }

    public function request($method, $endpoint, $data = null, $accept = 'application/json')
    {
        $options = [
            'auth'   => 'oauth',  // Use oauth plugin
            'verify' => __DIR__ . '/../ca-bundle.crt', // Needed for Xero's old certificates
            'headers' => ['Accept' => $accept]
        ];

        if (is_array($data) && isset($data['query'])) {
            $options['query'] = $data['query'];
            unset($data['query']);
            if (count($data) == 0) {
                $data = null;
            }
        }

        if ( ! is_null($data))
        {
            $options['body'] = $data;
        }

        try {
            $response = $this->client->$method($this->endpoint . $endpoint, $options);
        } catch (\Exception $e) {
            if ($e->getCode() === 503) {
                throw new XeroRatelimitExceededException;
            }

            throw new XeroApiException($this->container[count($this->container)-1]['response']->getBody()->getContents(), 0, $e);
        }
        return $response;
    }

    private function requestGet($endpoint)
    {
        /* @var Response $response */
        $response = $this->request('get', $endpoint);

        $json = $this->getArrayFromJsonBody($response);

        return $json;
    }

    private function requestPost($endpoint, $xml)
    {
        $response = $this->request('post', $endpoint, $xml);

        $json = $this->getArrayFromJsonBody($response);

        return $json;
    }

    private function requestPut($endpoint, $xml)
    {
        $response = $this->request('put', $endpoint, $xml);

        $json = $this->getArrayFromJsonBody($response);

        return $json;
    }

    private function getPrivateKeyPath()
    {
        if (substr($this->privatekey, 0, 1) != '/')
            return __DIR__ . '/' . $this->privatekey;

        return $this->privatekey;
    }

    /**
     * @param Response $response
     * @return array
     */
    private function getArrayFromJsonBody($response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
