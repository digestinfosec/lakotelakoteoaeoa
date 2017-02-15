<?php
function shorten_string($oldstring, $wordsreturned)
{
    @$retval = $string;
    $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $oldstring);
    $string = str_replace("\n", " ", $string);
    $array = explode(" ", $string);

    if (count($array) <= $wordsreturned) {
        $retval = $string;
    } else {
        array_splice($array, $wordsreturned);
        $retval = implode(" ", $array) . " ...";
    }
    return $retval;
}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}
