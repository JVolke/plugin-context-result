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
 * Class JavaScriptPackerCompressor.
 *
 * @package WyriHaximus\HtmlCompress\Compressor
 */
final class JavaScriptPackerCompressor extends Compressor
{
    /**
     * {@inheritdoc}
     */
    protected function execute(string $string): string
    {
        $parser = new \JavaScriptPacker($string);

        return $parser->pack();
    }
}
