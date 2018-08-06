<?php declare(strict_types=1);
/*
 * This file is part of HtmlCompress.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContextResult\HtmlCompress\Compressor;

/**
 * Class HtmlCompressor.
 *
 * @package WyriHaximus\HtmlCompress\Compressor
 */
final class HtmlCompressor extends Compressor
{
    /**
     * {@inheritdoc}
     */
    protected function execute(string $string): string
    {
        // Replace newlines, returns and tabs with spaces
        $string = str_replace(["\r", "\n", "\t"], ' ', $string);
        // Replace multiple spaces with a single space
        $string = preg_replace('/(\s+)/mu', ' ', $string);

        // Remove spaces that are followed by either > or <
        $string = preg_replace('/ (>)/', '$1', $string);
        // Remove spaces that are preceded by either > or <
        $string = preg_replace('/(<) /', '$1', $string);
        // Remove spaces that are between > and <
        $string = preg_replace('/(>) (<)/', '>$2', $string);
        // Remove comments
        $string = preg_replace('/<!--[^]><!\[](.*?)[^\]]-->/s', '', $string);

        return trim($string);
    }
}
