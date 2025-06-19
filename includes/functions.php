<?php
declare(strict_types=1);

/**
 * Wrapper for htmlspecialchars() function.
 * @param string $string The string to escape.
 * @return string The escaped string.
 */
function hsc(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}