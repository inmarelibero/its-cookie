<?php

class PasswordHasher
{
    /**
     * @param string $input
     * @return string
     */
    public static function hashPassword(string $input): string
    {
        return md5($input);
    }
}