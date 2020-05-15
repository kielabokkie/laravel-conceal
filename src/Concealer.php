<?php

namespace Kielabokkie\LaravelConceal;

use Illuminate\Support\Collection;

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

        throw new \Exception('Only Collections or Arrays are supported');
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
            if (is_string($item) === true) {
                return $this->handleString($key, $item);
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
            if (is_string($item) === true) {
                $input[$key] = $this->handleString($key, $item);
            }

            if (is_array($item) === true) {
                $input[$key] = $this->handleArray($item);
            }

            if ($item instanceof Collection) {
                $input[$key] = $this->handleCollection($item);
            }
        }

        return $input;
    }

    /**
     * Return concealed string if the key matches one of keys to be concealed.
     *
     * @param string $key
     * @param string $value
     * @return string
     */
    private function handleString($key, $value)
    {
        // If the key is
        if (in_array($key, $this->keys) === true) {
            return '********';
        }

        return $value;
    }
}
