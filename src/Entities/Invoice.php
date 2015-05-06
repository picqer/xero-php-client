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
    protected $Date;
    protected $DueDate;
    protected $Status;
    protected $SentToContact;
    protected $ExpectedPaymentDate;
    protected $PlannedPaymentDate;
    protected $SubTotal;
    protected $TotalTax;
    protected $Total;
    protected $TotalDiscount;
    protected $CurrencyCode;
    protected $LineAmountTypes;
    protected $AmountPaid;
    protected $FullyPaidOnDate;

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

    public function getXmlName()
    {
        return 'Invoice';
    }

    public function getIgnoredPutPostValues()
    {
        return [
            'DateString',
            'DueDateString',
            'Date',
            'DueDate'
        ];
    }

    public function addLineItem($lineitem)
    {
        $this->LineItems[] = $lineitem;
    }
}