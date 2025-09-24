<?php

/**
 * Laravel Tron Package - Cryptographic Utility Functions
 *
 * This package provides a comprehensive interface for interacting with the TRON blockchain
 * network, including account management, transaction handling, smart contract interaction,
 * and various utility functions for TRON development.
 *
 * @package    Jackillll\Tron\Support
 * @author     Jackillll <jackjack75383973@gmail.com> (Primary Developer)
 * @author     Shamsudin Serderov <steein.shamsudin@gmail.com> (Original Author)
 * @license    https://github.com/Jackillll/laravel-tron/blob/main/LICENSE MIT License
 * @version    2.0.0
 * @link       https://github.com/Jackillll/laravel-tron
 */

namespace Jackillll\Tron\Support;

/**
 * Cryptographic Utility Class
 *
 * Provides essential cryptographic utility functions for TRON blockchain operations
 * including number base conversion, binary data manipulation, and mathematical
 * operations required for blockchain cryptography.
 *
 * Key features:
 * - Decimal to binary conversion using BCMath
 * - Base conversion between different number systems
 * - Binary data manipulation utilities
 * - Support for large number arithmetic
 * - Essential for address generation and validation
 * - Required for cryptographic hash operations
 *
 * This class requires the BCMath PHP extension for precise large number arithmetic.
 *
 * @package Jackillll\Tron\Support
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @author  Shamsudin Serderov <steein.shamsudin@gmail.com>
 * @since   2.0.0
 */
class Crypto
{
    public static function bc2bin($num)
    {
        return self::dec2base($num, 256);
    }

    public static function dec2base($dec, $base, $digits = false)
    {
        if (extension_loaded('bcmath')) {
            if ($base < 2 || $base > 256) {
                die("Invalid Base: " . $base);
            }
            bcscale(0);
            $value = "";
            if (!$digits) {
                $digits = self::digits($base);
            }
            while ($dec > $base - 1) {
                $rest = bcmod($dec, $base);
                $dec = bcdiv($dec, $base);
                $value = $digits[$rest] . $value;
            }
            $value = $digits[intval($dec)] . $value;
            return (string)$value;
        } else {
            die('Please install BCMATH');
        }
    }

    public static function base2dec($value, $base, $digits = false)
    {
        if (extension_loaded('bcmath')) {
            if ($base < 2 || $base > 256) {
                die("Invalid Base: " . $base);
            }
            bcscale(0);
            if ($base < 37) {
                $value = strtolower($value);
            }
            if (!$digits) {
                $digits = self::digits($base);
            }
            $size = strlen($value);
            $dec = "0";
            for ($loop = 0; $loop < $size; $loop++) {
                $element = strpos($digits, $value[$loop]);
                $power = bcpow($base, $size - $loop - 1);
                $dec = bcadd($dec, bcmul($element, $power));
            }
            return (string)$dec;
        } else {
            die('Please install BCMATH');
        }
    }

    public static function digits($base)
    {
        if ($base > 64) {
            $digits = "";
            for ($loop = 0; $loop < 256; $loop++) {
                $digits .= chr($loop);
            }
        } else {
            $digits = "0123456789abcdefghijklmnopqrstuvwxyz";
            $digits .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ-_";
        }
        $digits = substr($digits, 0, $base);
        return (string)$digits;
    }

    public static function bin2bc($num)
    {
        return self::base2dec($num, 256);
    }
}
