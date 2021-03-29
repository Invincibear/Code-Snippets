<?php

// Generates a random 6-character HEX color
// Returns including the leading # symbol, e.g. returns '#A1B2C3'
function NewColor() {
    global $Log;

    $Log->debug('method Events::NewColor() called');

    $range = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F'];
    $color = [];

    for ($i = 1; $i <= 6; $i++) { // 6 itterations
        $color[] = $range[mt_rand(0, count($range) - 1)]; // Pick a random character from $range
    }

    $color = implode('', $color); // concantonate them all into a single string
    $color = "#{$color}";

    $Log->debug(['Returning randomly-generated color', $color]);

    return $color;
}

// This converts a #000 or #000000 hex color to rgb(#, #, #) color
// https://stackoverflow.com/a/5624139/1707636
// https://stackoverflow.com/a/15202130/1707636
/**
 * @param $hex
 * @return array
 */
function HexToRGB(string $hex) {
    global $Log;

    $Log->debug(['function HexToRGB($hex) called', $hex]);

    // Our regEx needs the # at the start of the hex to work.
    // If it's missing and we're given either a short or a full hex, prepend it with #
    if ($hex{0} !== '#' && (strlen($hex) === 3 || strlen($hex) === 6)) {
        $Log->debug([
            'prepending # to $hex',
            [
                '$hex'  => $hex,
                'new'   => "#{$hex}"
            ]
        ]);

        $hex = "#{$hex}"; // Prepend # to $hex
    } else if ($hex{1} === '#' && (strlen($hex) !== 4 || strlen($hex) !== 7)) {
        $Log->error(['Invalid length of $hex provided', $hex]);
        // Invalid $hex provided

        return [0, 0, 0];
    }

    // See the 'x' specifier in https://www.php.net/manual/en/function.sprintf.php
    // sscanf is the input analog of sprintf
    // "#%1x%1x%1x" reads #00AA33 as
    //      #  = literal #
    //      %1x = 1 of anything, transformed to hexadecimal
    // "#%2x%2x%2x" reads #00AA33 as
    //      #  = literal #
    //      %2x = 2 of anything, transformed to hexadecimal
    $rgb =
        (strlen($hex) === 4)
            ? list($red, $green, $blue) = sscanf($hex, "#%1x%1x%1x")
            : list($red, $green, $blue) = sscanf($hex, "#%2x%2x%2x");

    $Log->debug(['Extracted $rgb from $hex',
        [
            '$hex'  => $hex,
            '$rgb'  => $rgb
        ]
    ]);

    return $rgb;
}


// Determines if a light or dark font should be used over a provided (background) color is itself light or dark
// https://stackoverflow.com/a/1855903/1707636
// https://stackoverflow.com/a/36888120/1707636
function IsColorDark($red, $green, $blue) {
    global $Log;

    $Log->debug([
        'function IsColorDark($red, $green, $blue) called',
        [
            '$red'  => $red,
            '$green'=> $green,
            '$blue' => $blue
        ]
    ]);

    return ((((0.299 * $red) + (0.587 * $green) + (0.114 * $blue)) / 255) < .5);
}
