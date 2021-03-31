<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('numerical')) {
    /**
     * Helper get decimal value if needed.
     * @param $number
     * @param int $precision
     * @param bool $trimmed
     * @param string $dec_point
     * @param string $thousands_sep
     * @return int|string
     */
    function numerical($number, $precision = 3, $trimmed = false, $dec_point = ',', $thousands_sep = '.')
    {
        if (empty($number)) {
            return 0;
        }
        $formatted = number_format($number, $precision, $dec_point, $thousands_sep);

        if (!$trimmed) {
            return $formatted;
        }

        // Trim unnecessary zero after comma: (2,000 -> 2) or (3,200 -> 3,2)
        return strpos($formatted, $dec_point) !== false ? rtrim(rtrim($formatted, '0'), $dec_point) : $formatted;;

        /* Trim only zero after comma: (2,000 -> 2) but (3,200 -> 3,200)
        $decimalString = '';
        for ($i = 0; $i < $precision; $i++) {
            $decimalString .= '0';
        }
        $trimmedNumber = str_replace($dec_point . $decimalString, "", (string)$formatted);
        return $trimmedNumber;
        */
    }
}

if (!function_exists('sql_date_format')) {
    /**
     * Change format string to sql date
     * @param $string
     * @param bool $withTime
     * @param string $default
     * @return string
     */
    function sql_date_format($string, $withTime = true, $default = '')
    {
        if (empty($string)) {
            return $default;
        } else if ($string == 'now') {
            return (new DateTime($string))->format('Y-m-d' . ($withTime ? ' H:i:s' : ''));
        } else {
            $timeFormat = '';
            if ($withTime) {
                $timeFormat = ' H:i:s';
            }
            return (new DateTime($string))->format('Y-m-d' . $timeFormat);
        }
    }
}

if (!function_exists('values')) {
    /**
     * Helper get decimal value if needed.
     * @param $value
     * @param string $default
     * @param string $prefix
     * @param string $suffix
     * @param bool $strict
     * @return array|string
     */
    function values($value, $default = '', $prefix = '', $suffix = '', $strict = false)
    {
        if (is_null($value) || empty($value) || $value == 'undefined') {
            return $default;
        }

        if ($strict) {
            if ($value == '0' || $value == '-' || $value == '0000-00-00' || $value == '0000-00-00 00:00:00') {
                return $default;
            }
        }

        if (is_array($value)) {
            return $value;
        }

        return is_null($default) ? $value : $prefix . $value . $suffix;
    }
}

if (!function_exists('if_empty')) {
    /**
     * Helper get value if exist..
     * @param $value
     * @param string $default
     * @param string $prefix
     * @param string $suffix
     * @param bool $strict
     * @return array|string
     */
    function if_empty($value, $default = '', $prefix = '', $suffix = '', $strict = false)
    {
        return values($value, $default, $prefix, $suffix, $strict);
    }
}

if (!function_exists('get_if_exist')) {
    /**
     * Helper get decimal value if needed.
     * @param $array
     * @param string $key
     * @param string $default
     * @return array|string
     */
    function get_if_exist($array, $key = '', $default = '')
    {
        if (key_exists($key, if_empty($array, []))) {
            if (!empty($array[$key])) {
                return $array[$key];
            }
        }

        return $default;
    }
}

if (!function_exists('readable_date')) {
    /**
     * Helper get full text date spelled.
     * @param $value
     * @param bool $withTime
     * @param string $default
     * @return string
     */
    function readable_date($value, $withTime = true, $default = '-')
    {
        if (empty($value)) {
            return $default;
        } else if ($value == 'now') {
            return (new DateTime($value))->format('d F Y' . ($withTime ? ' H:i:s' : ''));
        }

        return (new DateTime($value))->format('d F Y' . ($withTime ? ' H:i' : ''));
    }
}

if (!function_exists('readable_date_id')) {
    /**
     * Helper get full text date spelled in indonesia language.
     * @param $value
     * @param bool $withTime
     * @param string $default
     * @return string
     */
    function readable_date_id($value, $withTime = true, $default = '-')
    {
        setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
        if (empty($value)) {
            return $default;
        } else if ($value == 'now') {
            return strftime('%d %B %Y' . ($withTime ? ' %H:%M:%S' : ''), now());
        }

        return strftime('%d %B %Y' . ($withTime ? ' %H:%M:%S' : ''), strtotime($value));
    }
}

if (!function_exists('format_date')) {
    /**
     * Helper get decimal value if needed.
     * @param $value
     * @param string $format
     * @return string
     */
    function format_date($value, $format = 'Y-m-d')
    {
        if (empty($value)) {
            return $value;
        }
        return (new DateTime($value))->format($format);
    }
}

if (!function_exists('difference_date')) {
    /**
     * Helper get difference by two dates.
     * @param $firstDate
     * @param $secondDate
     * @param string $format
     * @return string
     */
    function difference_date($firstDate, $secondDate, $format = '%R%a')
    {
        $date1 = date_create($firstDate);
        $date2 = date_create($secondDate);
        $diff = date_diff($date1, $date2);
        $diffInFormat = $diff->format($format);

        return intval($diffInFormat);
    }
}

if (!function_exists('extract_time')) {
    /**
     * Helper get decimal value if needed.
     * @param $value
     * @param bool $withSecond
     * @return string
     */
    function extract_time($value, $withSecond = true)
    {
        if (empty($value)) {
            return '-';
        }
        return (new DateTime($value))->format('H:i' . ($withSecond ? ':s' : ''));
    }
}

if (!function_exists('leading_number')) {
    /**
     * Helper get decimal value if needed.
     * @param $value
     * @param int $leadingTotal
     * @param string $leadingChar
     * @param int $leadingPosition
     * @return string
     */
    function leading_number($value, $leadingTotal = 3, $leadingChar = '0', $leadingPosition = STR_PAD_LEFT)
    {
        return str_pad($value, $leadingTotal, $leadingChar, $leadingPosition);
    }
}

if (!function_exists('print_all')) {
    /**
     * Print recursively all message
     * @param $data
     * @param int $nest
     */
    function print_all($data, $nest = 0)
    {
        if (!is_array($data)) {
            for ($i = 0; $i < $nest; $i++) {
                echo '&nbsp;';
            }
            echo $data . '<br>';
            return;
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                echo $key . ':<br>';
                print_all($value, $nest + 5);
            } else {
                print_all($key . ': ' . $value, $nest);
            }
        }

    }
}

if (!function_exists('print_debug')) {
    /**
     * Print pre formatted data.
     * @param $data
     * @param bool $die_immediately
     */
    function print_debug($data, $die_immediately = true)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($die_immediately) {
            die();
        }
    }
}

if (!function_exists('extract_number')) {

    function extract_number($value)
    {
        $value = preg_replace("/[^0-9-,\/]/", "", $value);
        $value = preg_replace("/,/", ".", $value);
        return $value;
    }
}

if (!function_exists('roman_number')) {
    function roman_number($integer, $upCase = true)
    {
        $table = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $return = '';
        while ($integer > 0) {
            foreach ($table as $rom => $arb) {
                if ($integer >= $arb) {
                    $integer -= $arb;
                    $return .= $rom;
                    break;
                }
            }
        }
        return $upCase ? $return : strtolower($return);
    }
}

if (!function_exists('number_spelled')) {
    function number_spelled($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int)$num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int)(($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int)($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int)($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int)($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && ( int )($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return ucfirst(implode(' ', $words));
    }
}

if (!function_exists('number_spelled_id')) {
    /**
     * @param $num
     * @return string
     */
    function number_spelled_id($num)
    {
        $num = trim((int)$num);

        $placeholders = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
        $numberWords = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan');
        $numberGroups = array('', 'ribu', 'juta', 'milyar', 'triliun');

        $numLength = strlen($num);

        if ($numLength > 15) {
            return 'Maximum number is 15 digits';
        }

        // put numbers item into placeholder
        for ($i = 1; $i <= $numLength; $i++) {
            $placeholders[$i] = substr($num, -($i), 1);
        }

        $i = 1;
        $j = 0;
        $spelledNum = "";


        /* mulai proses iterasi terhadap array angka */
        while ($i <= $numLength) {

            $subSpelled = "";
            $group1 = "";
            $group2 = "";
            $group3 = "";

            // hundred group
            if ($placeholders[$i + 2] != "0") {
                if ($placeholders[$i + 2] == "1") {
                    $group1 = "seratus";
                } else {
                    $group1 = $numberWords[$placeholders[$i + 2]] . " ratus";
                }
            }

            // tens group
            if ($placeholders[$i + 1] != "0") {
                if ($placeholders[$i + 1] == "1") {
                    if ($placeholders[$i] == "0") {
                        $group2 = "sepuluh";
                    } elseif ($placeholders[$i] == "1") {
                        $group2 = "sebelas";
                    } else {
                        $group2 = $numberWords[$placeholders[$i]] . " belas";
                    }
                } else {
                    $group2 = $numberWords[$placeholders[$i + 1]] . " puluh";
                }
            }

            // the rest of it
            if ($placeholders[$i] != "0") {
                if ($placeholders[$i + 1] != "1") {
                    $group3 = $numberWords[$placeholders[$i]];
                }
            }

            // spell start ahead
            if (($placeholders[$i] != "0") OR ($placeholders[$i + 1] != "0") OR ($placeholders[$i + 2] != "0")) {
                $subSpelled = "$group1 $group2 $group3 " . $numberGroups[$j] . " ";
            }

            // group spell and jump to thousand and counter
            $spelledNum = $subSpelled . $spelledNum;
            $i = $i + 3;
            $j = $j + 1;

        }

        // replace the result for some condition
        if (($placeholders[5] == "0") AND ($placeholders[6] == "0")) {
            $spelledNum = str_replace("satu ribu", "seribu", $spelledNum);
        }

        return trim($spelledNum);
    }
}

if (!function_exists('get_string_between')) {
    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}

if (!function_exists('item_summary_modifier')) {
    function item_summary_modifier($string, $pattern = '~\(([\d.]+)([A-Z]+-)([\d,.]+)(Kg-)([\d.]+)~')
    {
        return preg_replace_callback(
            $pattern,
            function ($m) {
                return
                    "(" .
                    numerical($m[1], 3, true) .
                    "$m[2]" .
                    numerical($m[3], 3, true) .
                    "$m[4]" .
                    numerical($m[5], 3, true);
            },
            $string);
    }
}


if (!function_exists('mask_tax_number')) {
    function mask_tax_number($tax)
    {
        $tax = substr_replace($tax, '.', 2, 0);
        $tax = substr_replace($tax, '.', 6, 0);
        $tax = substr_replace($tax, '.', 10, 0);
        $tax = substr_replace($tax, '-', 12, 0);
        $tax = substr_replace($tax, '.', 16, 0);

        return $tax;
    }
}

if (!function_exists('power_set')) {
    function power_set($str_array)
    {
        $set_size = count($str_array);
        $pow_set_size = pow(2, $set_size);
        $return = array();
        for ($counter = 0; $counter < $pow_set_size; $counter++) {
            $tmp_str = [];
            for ($j = 0; $j < $set_size; $j++) {
                if ($counter & (1 << $j)) {
                    $tmp_str[] = $str_array[$j];
                }
            }
            if (!empty($tmp_str)) {
                $return[] = $tmp_str;
            }
        }
        return $return;
    }
}

if (!function_exists('get_months')) {
    function get_months($index = null)
    {
        $months = array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December',
        );
        if (!empty($index)) {
            return $months[$index];
        }
        return $months;
    }
}
if (!function_exists('__')) {

    /**
     * Translate and replace by placeholder value
     *
     * @param string $line
     * @param array $placeholders
     * @return string
     */
    function __($line = '', $placeholders = [])
    {
        $line = get_instance()->lang->line($line);

        if (!key_exists(':class', $placeholders)) {
            $placeholders[':class'] = ucfirst(str_replace('_', ' ', get_instance()->router->class));
        }

        foreach ($placeholders as $placeholder => $value) {
            $line = str_replace('{' . $placeholder . '}', $value, $line);
        }


        return $line;
    }
}
