<?php

namespace App\Services;

use Symfony\Bundle\SecurityBundle\Security;
//use Symfony\Component\Security\Core\Security;
use Twig\Cache\CacheInterface;
use Psr\Log\LoggerInterface;

class MarkdownHelper
{

    public function __construct(
//        private MarkdownParserInterface $markdownParser,
        private CacheInterface  $cache,
        private readonly bool   $isDebug,
        private LoggerInterface $mdLogger,
        private Security        $security,
    )
    {

    }
    public function parse(string $source): string
    {
        if ($this->security->getUser()) {
            $this->logger->info('Rendering markdown for {user}', [
                'user' => $this->security->getUser()->getUserIdentifier()
            ]);
        }

        if (stripos($source, 'cat') !== false) {
            $this->logger->info('Meow!');
        }

//        if ($this->isDebug) {
//            return $this->markdownParser->transformMarkdown($source);
//        }
//        return $this->cache->get('markdown_'.md5($source), function() use ($source) {
//            return $this->markdownParser->transformMarkdown($source);
//        });
    }
}