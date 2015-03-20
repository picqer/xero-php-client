<?php

namespace Picqer\Xero\Entities;

class Invoice extends BaseEntity {

    protected $InvoiceID;
    protected $Type;
    protected $InvoiceNumber;
    protected $Reference;
    protected $AmountDue;
    protected $AmountCredited;
    protected $DateString;
    protected $DueDateString;
    protected $Status;
    protected $SubTotal;
    protected $TotalTax;
    protected $Total;
    protected $CurrencyCode;

    protected $LineItems = [];

    protected $Contact = [];

    protected function getChildEntities()
    {
        return [
            'LineItems' => 'InvoiceLineItem',
        ];
    }

    protected function getForeignEntities()
    {
        return [
            'Contact' => 'Contact'
        ];
    }

    public function getPrimaryKey()
    {
        return 'InvoiceID';
    }

    public function getEndpoint()
    {
        return '/invoices';
    }

}