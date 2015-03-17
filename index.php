<?php

require 'vendor/autoload.php';

function dd($contents)
{
    var_dump($contents);
    die();
}

$xero = new Picqer\Xero\Xero('2TC293AOKZLH4MUOSDQKTXYKXKFP4D', 'K1UJWP5H9KQYV8WQ3G3FEZLRBGLV4Y');

$response = $xero->getContact('75a1e823-b760-4993-b75e-b9720797428f');

dd($response);