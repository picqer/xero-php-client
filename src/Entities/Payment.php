<?php

namespace Picqer\Xero\Entities;

class Payment extends BaseEntity {
    protected $Date;
    protected $Reference;
    protected $Amount;
    protected $CurrencyRate;

    protected $Account = [];

    protected $Invoice = [];

    protected function getChildEntities()
    {
        return [
            'Payments' => 'Payment',
        ];
    }

    protected function getForeignEntities()
    {
        return [
            'Account' => 'Account',
            'Invoice' => 'Invoice'
        ];
    }

    public function getPrimaryKey()
    {
        return 'InvoiceID';
    }

    public function getEndpoint()
    {
        return '/payments';
    }

    public function getXmlName()
    {
        return 'Payment';
    }
    
    public function addPayment($payment)
    {
        $this->Payments[] = $payment;
    }
}