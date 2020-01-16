<?php

function datetime_now()
{
    return date('Y-m-d H:i:s', time());
}

function datetime_date($string)
{
    $date = explode("-", explode(" ", $string)[0]);
    return implode(".", array_reverse($date));
}

function datetime_datetime($string)
{
    $date = explode("-", explode(" ", $string)[0]);
    $time = explode(":", explode(" ", $string)[1]);
    array_pop($time);
    $date = implode(".", array_reverse($date));
    $time = implode(":", $time);
    return $date . " " . $time;
}

function datetime_time($string)
{
    $time = explode(":", explode(" ", $string)[1]);
    array_pop($time);
    return implode(":", $time);
}

function escape($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}
