<?php

namespace Picqer\Xero\Entities;

class InvoiceLineItem extends BaseEntity {

    protected $endpoint = '/contacts';
    protected $primaryKey = 'ContactId';

    protected $Description;
    protected $UnitAmount;
    protected $TaxType;
    protected $TaxAmount;
    protected $LineAmount;
    protected $AccountCode;
    protected $Quantity;
}