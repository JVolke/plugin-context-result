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

/**
 * Class BestResultCompressor.
 *
 * @package WyriHaximus\HtmlCompress\Compressor
 */
final class BestResultCompressor extends Compressor
{
    protected $compressors = [];

    public function __construct(array $compressors)
    {
        $this->compressors = $compressors;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(string $string): string
    {
        $result = $string;
        foreach ($this->compressors as $compressor) {
            $currentResult = $compressor->compress($string);

            if (strlen($currentResult) < strlen($result) && strlen($currentResult) > 0) {
                $result = $currentResult;
            }
        }

        return $result;
    }
}
