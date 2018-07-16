<?php
/**
 * Created by PhpStorm.
 * User: sureshkatwal
 * Date: 15/07/2018
 * Time: 22:23
 */

namespace App\Service;


use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    /**
     * @var MarkdownParserInterface
     */
    protected $markdown;

    /**
     * @var AdapterInterface
     */
    protected $cache;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(MarkdownParserInterface $markdown, AdapterInterface $cache, LoggerInterface $markdownLogger)
    {
        $this->markdown = $markdown;
        $this->cache = $cache;
        $this->logger = $markdownLogger;
    }

    /**
     * @param string $articleContent
     * @return string
     */
    public function parse(string $articleContent): string
    {
        $this->logger->info('this is some log');
        $item = $this->cache->getItem('markdown_' . md5($articleContent));
        if (!$item->isHit()) {
            $item->set($this->markdown->transform($articleContent));
            $this->cache->save($item);
        }

        $articleContent = $item->get();
        return $articleContent;
    }

}