<?php
namespace Picqer\Xero\Entities;
class SinglePayment extends BaseEntity {
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
}
