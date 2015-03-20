<?php

namespace Picqer\Xero\Entities;

class Invoice extends BaseEntity {

    protected $endpoint = '/invoices';
    protected $primaryKey = 'InvoiceID';

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

    protected $childEntities = [
        'LineItems' => 'InvoiceLineItem',
    ];

}