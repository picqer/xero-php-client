# xero-php-client
PHP Client library for the Xero oAuth API, only for private applications

**This package is not maintained anymore, we recommend this excellent alternative: https://packagist.org/packages/calcinai/xero-php**

## Composer install
Installing this Xero API client for PHP can be done through Composer.

    composer require picqer/xero-php-client

## Usage
Create a new Private Application in your Xero account: https://app.xero.com/Application/Add

Create a private key and certificate, and upload your certificate.

Start a Xero client:
```php
$xero = new Picqer\Xero\Xero('--api key--', '--api secret--', '--path to private key file--');
```
Provide your API key, API secret and the path to your private key file.

Now retrieve your invoices:
```php
$invoices = $xero->getInvoices();
```
## Create a new contact
```php
$contact = new Picqer\Xero\Entities\Contact();
$contact->Name = 'Casper Bakker Demo';
    
$address = new Picqer\Xero\Entities\ContactAddress();
$address->City = 'Doesburg';
$contact->Addresses = [ $address ];
    
$response = $xero->create($contact);
```
## Create a new invoice
```php
$invoice = new Picqer\Xero\Entities\Invoice();
$invoice->Type = 'ACCREC';
$invoice->LineAmountTypes = 'Exclusive';
$invoice->Date = new DateTime();
$invoice->DueDate = new DateTime('+2 weeks');
    
$lineitem = new Picqer\Xero\Entities\InvoiceLineItem();
$lineitem->Description = 'Subscription';
$lineitem->UnitAmount = 12.95;
$lineitem->AccountCode = '8100';
$lineitem->Quantity = 2;
    
$invoice->addLineItem($lineitem);
    
$invoice->Contact = $xero->getContact('--existing customer id--');

$response = $xero->create($invoice);
```
