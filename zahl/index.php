<?php

// (E)va

class Toolbox
{

    public function dec2hex($dec)
    {

        $hex = '';
        while ($dec > 0) {
            $last = bcmod($dec, 16);
            $hex = dechex($last).$hex;
            $dec = bcdiv(bcsub($dec, $last), 16);
        }


        if ($hex === '') {

            $hex = '0';
        }

        return strtoupper($hex);


    }



    public function dec2bin($input)
    {
        $binary_str = '';
        $check1 = '1';
        $check0 = '0';

        $_input = $input;
        if (!$input || !is_numeric($input)) {
            $binary_str = '0';
        } else {
            while ($input >= 1) {
                if ($input % 2 >= 1) {
                    $binary_str = '1'.$binary_str;
                } else {
                    $binary_str = '0'.$binary_str;
                }
                $input /= 2;
            }
        }



        return $binary_str;
    }


    public function bin2dec($input)
    {

        $input = bindec($input);

        return $input;


    }


    public function bin2hex($input)
    {

        $input = bindec($input);


        $input = $this->dec2hex($input);

        return $input;

    }


    public function hex2dec($input)
    {

        $input = hexdec($input);


        return $input;

    }


    public function hex2bin($input)
    {

        $input = hexdec($input);


        $input = $this->dec2bin($input);

        return $input;

    }


}

$toolbox = new Toolbox();


$source = null;
$sourceBinary = '';
$sourceHex = '';
$sourceDecimal = '';
$results = [];

if (isset($_GET['source']) && isset($_GET['input'])) {
    // Jetzt können wir was rechnen
    $source = $_GET['source'];
    $input = trim($_GET['input']);

    if ($source === 'binary') {
        $sourceBinary = 'selected';
       /* if (!strstr($input, '1') || !strstr($input, '0') && !strstr($input, '1') && !strstr($input, '0')){

            die('Keine Binärzahl!');
        }*/

        if (!preg_match('/^[0-1]+$/', $input)) {
            die('Keine Binärzahl!');
        }

    } elseif ($source === 'hex') {
        $sourceHex = 'selected';
        if (!ctype_xdigit($input)) {
            die('Keine Hexadezimalzahl!');
        }

    } elseif ($source === 'decimal') {
        $sourceDecimal = 'selected';
        if (!ctype_digit($input)) {
            die('Keine Dezimalzahl!');
        }

    }
}

// e(V)a
// -----------------------------

if ($source === 'decimal') {

    $results = ['DEC: '.$input, 'HEX: '.$toolbox->dec2hex($input), 'BIN: '.$toolbox->dec2bin($input)];
} else {
    if ($source === 'hex') {
        $results = ['HEX: '.strtoupper($input), 'BIN: '.$toolbox->hex2bin($input), 'DEC: '.$toolbox->hex2dec($input)];

    } else {
        if ($source === 'binary') {

            $results = ['BIN:'.$input, 'HEX: '.$toolbox->bin2hex($input), 'DEC: '.$toolbox->bin2dec($input)];


        }
    }
}


// -----------------------------

// ev(A)
$html = file_get_contents('zahlenumwandler.html');


// Replace placeholders
$html = str_replace(
    [
        '{{ input }}',
        '{{ results }}',
        '{{ source-binary }}',
        '{{ source-hex }}',
        '{{ source-decimal }}',
    ],
    [
        trim($input),
        $results[0].'<br><br>'.$results[1].'<br><br>'.$results[2],
        $sourceBinary,
        $sourceHex,
        $sourceDecimal,
    ],
    $html
);


// Output
echo $html;



// functions



