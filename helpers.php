<?php

function random()
{
    return mt_rand() / mt_getrandmax();
}
