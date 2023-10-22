<?php

class RequestHelper
{
    /**
     * Build a path by optionally concatenating some query parameters
     *
     * @param string $path
     * @param array $queryParameters key: query parameter name, value: parameter value
     * @return string
     */
    public static function buildPathWithQueryParameters(string $path, array $queryParameters = []): string
    {
        /*
         *
         */
        $queryParameters = array_filter($queryParameters, function ($value) {
            return !empty($value);
        });

        /*
         * build query portion
         */
        $query = '';

        if (count($queryParameters) > 0) {
            $query = '?'.http_build_query($queryParameters);
        }

        /*
         * return final path
         */
        return $path . $query;
    }

    /**
     * Return the value for a specific Query parameter, if any
     *
     * @param string $name
     * @return string|null
     */
    public static function getQueryParameter(string $name): ?string
    {
        if (array_key_exists($name, $_GET)) {
            return $_GET[$name];
        }

        return null;
    }
}
