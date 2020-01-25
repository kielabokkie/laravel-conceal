<?php

use Kielabokkie\LaravelConceal\Concealer;

if (! function_exists('conceal')) {
    /**
     * Conceal given keys or an Array or Collection.
     *
     * @param mixed $input
     * @param array $keys
     * @return mixed
     */
    function conceal($input, array $keys = [])
    {
        $concealer = new Concealer;

        return $concealer->conceal($input, $keys);
    }
}
