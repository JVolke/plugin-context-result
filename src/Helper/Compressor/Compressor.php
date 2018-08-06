<?php 
/*
 * This file is part of HtmlCompress.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContextResult\HtmlCompress\Compressor;

abstract class Compressor implements CompressorInterface
{
    public function compress(string $source): string
    {
        $result = $this->execute($source);

        if (strlen($source) >= strlen($result)) {
            return $result;
        }

        return $source;
    }

    abstract protected function execute(string $string): string;
}
