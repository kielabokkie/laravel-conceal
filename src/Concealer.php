<?php

namespace Kielabokkie\LaravelConceal;

use Illuminate\Support\Arr;

class Concealer
{
    /**
     * Conceal given keys or an Array or Collection.
     *
     * @param mixed $input
     * @param array $keys
     * @return mixed
     */
    public function conceal($input, array $keys = [])
    {
        foreach ($keys as $key) {
            if (Arr::get($input, $key)) {
                Arr::set($input, $key, '********');
            }
        }

        return $input;
    }
}
