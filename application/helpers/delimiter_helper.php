<?php

function delimiter_number($currency, $price)
{
    if ($currency == "SGD" || $currency == "S$") {
        $currency = "S$";
        $price = number_format($price, 0, '.', ',');
    } else {
        $currency = "Rp";
        $price = number_format($price, 0, '.', '.');
    }
    return $currency . " " . $price;
}

function delimiter_number_dec($currency, $price, $decimal)
{
    if ($currency == "SGD" || $currency == "S$") {
        $currency = "S$";
        $price = number_format($price, $decimal, '.', ',');
    } else {
        $currency = "Rp";
        $price = number_format($price, 0, '.', '.');
    }
    return $currency . " " . $price;
}