<?php

namespace Picqer\Xero\Entities;
class Payment extends BaseEntity {
    protected $Invoice;
    protected $Account;
    protected $CreditNoteID;
    protected $PrepaymentID;
    protected $OverpaymentID;
    protected $InvoiceNumber;
    protected $CreditNoteNumber;
    protected $CreditNote;
    protected $AccountID;
    protected $Code;
    protected $Date;
    protected $CurrencyRate;
    protected $Amount;
    protected $Reference;
    protected $IsReconciled;
    protected $Status;
    protected $PaymentType;
    public function getXmlName()
    {
        return 'Payment';
    }
    public function getEndpoint()
    {
        return '/payments';
    }
    protected function getChildEntities()
    {
        return [
            'Invoice' => 'PaymentInvoice',
            'CreditNote' => 'CreditNote'
        ];
    }
}