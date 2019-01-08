<?php

namespace Picqer\Xero\Entities;

class InvoiceLineItem extends BaseEntity {

    protected $Description;
    protected $UnitAmount;
    protected $TaxType;
    protected $TaxAmount;
    protected $LineAmount;
    protected $AccountCode;
    protected $Quantity;
    protected $ItemCode;
    protected $DiscountRate;
    
    public function getXmlName()
    {
        return 'LineItem';
    }

}