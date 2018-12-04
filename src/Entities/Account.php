<?php
namespace Picqer\Xero\Entities;
class Account extends BaseEntity {
    protected $AccountID;
    protected $Name;
    protected $Status;
    protected $Type;
    protected $TaxType;
    protected $Class;
    protected $EnablePaymentsToAccount;
    protected $ShowInExpenseClaims;
    protected $BankAccountNumber;
    protected $BankAccountType;
    protected $CurrencyCode;
    protected $ReportingCode;
    protected $ReportingCodeName;
    protected $HasAttachments;
    public function getPrimaryKey()
    {
        return 'AccountID';
    }
    public function getEndpoint()
    {
        return '/accounts';
    }
    public function getXmlName()
    {
        return 'Account';
    }
}
