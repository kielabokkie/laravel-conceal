<?php

namespace Kielabokkie\LaravelConceal;

use Illuminate\Support\Collection;
use Kielabokkie\LaravelConceal\Exceptions\NotSupportedException;

class Concealer
{
    /**
     * Array of keys that should be concealed.
     *
     * @var array
     */
    private $keys = [];

    /**
     * Conceal given keys or an Array or Collection.
     *
     * @param mixed $input
     * @param array $keys
     * @return mixed
     */
    public function conceal($input, array $keys = [])
    {
        // Merge default keys with given keys
        $this->keys = array_unique(array_merge(config('conceal.defaults'), $keys));

        if ($input instanceof Collection) {
            $output = $this->handleCollection($input);
            return $output;
        }

        if (is_array($input) === true) {
            $output = $this->handleArray($input);
            return $output;
        }

        throw new NotSupportedException;
    }

    /**
     * Handle concealing of collections.
     *
     * @param \Illuminate\Support\Collection $input
     * @return \Illuminate\Support\Collection
     */
    private function handleCollection($input)
    {
        $output = $input->map(function ($item, $key) {
            if (in_array($key, $this->keys) === true) {
                return $input[$key] = '********';
            }

            if ($item instanceof Collection) {
                return $this->handleCollection($item);
            }

            if (is_array($item) === true) {
                return $this->handleArray($item);
            }

            return $item;
        });

        return $output;
    }

    /**
     * Handle concealing of arrays.
     *
     * @param array $input
     * @return array
     */
    private function handleArray($input)
    {
        foreach ($input as $key => $item) {
            if (in_array($key, $this->keys) === true) {
                $input[$key] = '********';
                continue;
            }

            if (is_array($item) === true) {
                $input[$key] = $this->handleArray($item);
                continue;
            }

            if ($item instanceof Collection) {
                $input[$key] = $this->handleCollection($item);
                continue;
            }
        }

        return $input;
    }
}
