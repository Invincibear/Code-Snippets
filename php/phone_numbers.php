<?php

function formatPhoneNumber($number) {
	$number = stripPhoneNumber($number);
	$length = strlen($number);
	$output = null;

	if ($length == 7) {//123-4567
		$output = substr($number, 0, 3) . '-' . substr($number, 3, 4);
	} else if ($length > 7 && $length < 10) {//123-4567x99
		$output = substr($number, 0, 3) . '-' . substr($number, 3, 4) . 'x' . substr($number, 6);
	} else if ($length == 10) {//780-123-4567
		$output = substr($number, 0, 3) . '-' . substr($number, 3, 3) . '-' . substr($number, 6);
	} else if ($length > 10) {
		if ($number{0} == 1) {
			if ($length == 11) {//1-888-123-4567
				$output = $number{0} . '-' . substr($number, 1, 3) . '-' . substr($number, 4, 3) . '-' . substr($number, 7);
			} else {//1-888-123-4567x999
				$output = $number{0} . '-' . substr($number, 1, 3) . '-' . substr($number, 4, 3) . '-' . substr($number, 7, 4) . 'x' . substr($number, 11);
			}
		} else {//780-123-4567x999
			$output = substr($number, 0, 3) . '-' . substr($number, 3, 3) . '-' . substr($number, 6, 4) . 'x' . substr($number, 10);
		}
	}

	return $number;#strtolower($output);
}

function stripPhoneNumber($number) {
	return str_replace(array('-', '+'), '', (trim(filter_var($number, FILTER_SANITIZE_NUMBER_INT))));
}