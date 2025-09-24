<?php

/**
 * Laravel Tron Package - Base58 Encoding/Decoding Implementation
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
 * Base58 Encoding and Decoding Class
 *
 * Provides Base58 encoding and decoding functionality specifically designed for
 * TRON blockchain address format handling. Base58 is used in TRON to create
 * human-readable addresses that avoid confusing characters like 0, O, I, and l.
 *
 * Key features:
 * - Encode numeric values to Base58 strings
 * - Decode Base58 strings back to numeric values
 * - Uses Bitcoin-style Base58 alphabet
 * - Essential for TRON address format conversion
 * - Supports custom alphabet length for flexibility
 *
 * This class is fundamental for TRON address manipulation and validation.
 *
 * @package Jackillll\Tron\Support
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @author  Shamsudin Serderov <steein.shamsudin@gmail.com>
 * @since   2.0.0
 */
class Base58
{
    /**
     * Encodes the passed whole string to base58.
     *
     * @param $num
     * @param int $length
     *
     * @return string
     */
    public static function encode($num, $length = 58): string
    {
        return Crypto::dec2base($num, $length, '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');
    }

    /**
     * Base58 decodes a large integer to a string.
     *
     * @param string $addr
     * @param int $length
     *
     * @return string
     */
    public static function decode(string $addr, int $length = 58): string
    {
        return Crypto::base2dec($addr, $length, '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');
    }
}
