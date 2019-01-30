<?php
namespace Picqer\Xero\Entities;
class PaymentInvoice extends BaseEntity
{
    protected $InvoiceID;
    public function getXmlName()
    {
        return 'Invoice';
    }
}