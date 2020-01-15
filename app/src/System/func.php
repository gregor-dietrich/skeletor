<?php

function datetime_now()
{
    return date('Y-m-d H:i:s', time());
}

function escape($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}
