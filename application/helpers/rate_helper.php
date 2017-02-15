<?php

function show_rate($rate)
{
    $output = '';
    $rate = intval($rate);

    for ($i = 0; $i < 5; $i++) {
        if ($rate > 0) {
            $output .= '<img src="' . base_url() . 'assets/images/rating-active.png" alt="">';
        } else {
            $output .= '<img src="' . base_url() . 'assets/images/rating.png" alt="">';
        }

        $rate--;
    }

    return $output;
}
