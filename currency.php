<?php

function formatPrice($price) {
    $price = str_replace(['$', '€', '£'], '', $price); // Strip out currency symbols

    $thousands_separator = ' '; // Use , for USD, comma is most popular

	$price	= preg_replace('/\s+/', '', $price); // Remove spaces
    $price	= floatval($price); // Convert to a FLOAT
    
	return number_format($price, 2, '.', $thousands_separator); // Return the formatted value, enforcing two decimal places every time
#	return sprintf("%01.2f", $price);
#	return money_format('%!.2n', $price);
}