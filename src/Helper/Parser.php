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
use ContextResult\HtmlCompress\Compressor\HtmlCompressor;

/**
 * Class Parser.
 *
 * @package WyriHaximus\HtmlCompress
 */
final class Parser implements ParserInterface
{
    /**
     * @var Compressor\CompressorInterface|Compressor\HtmlCompressor
     */
    protected $defaultCompressor;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param array               $options
     * @param CompressorInterface $defaultCompressor
     */
    public function __construct(array $options, CompressorInterface $defaultCompressor = null)
    {
        $this->options = $options;

        if ($defaultCompressor === null) {
            $defaultCompressor = new HtmlCompressor();
        }
        $this->defaultCompressor = $defaultCompressor;
    }

    /**
     * @param  string $html
     * @return string
     */
    public function compress(string $html): string
    {
        $tokens = $this->tokenize($html);

        $compressedHtml = '';
        do {
            $token = array_shift($tokens);
            $compressedHtml .= $token->getCompressor()->compress($token->getCombinedHtml());
        } while (count($tokens) > 0);

        return $compressedHtml;
    }

    /**
     * @param  string $html
     * @return array
     */
    public function tokenize(string $html): array
    {
        return Tokenizer::tokenize($html, $this->getCompressors(), $this->getDefaultCompressor());
    }

    /**
     * @return CompressorInterface
     */
    public function getDefaultCompressor(): CompressorInterface
    {
        return $this->defaultCompressor;
    }

    /**
     * @return mixed
     */
    public function getCompressors(): array
    {
        return $this->options['compressors'];
    }
}
