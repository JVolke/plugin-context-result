<?php
/*
 * This file is part of HtmlCompress.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContextResult\HtmlCompress;

use ContextResult\HtmlCompress\Compressor\CompressorInterface;

/**
 * Class Parser.
 *
 * @package WyriHaximus\HtmlCompress
 */
interface ParserInterface
{
    public function compress(string $html): string;

    public function tokenize(string $html): array;

    public function getDefaultCompressor(): CompressorInterface;

    public function getCompressors(): array;
}
