<?php

namespace Blueways\BwCacheUri\Processor;

use Symfony\Component\DomCrawler\Crawler;

class RssProcessor implements PostProcessorInterface
{

    /**
     * @param string $dom
     * @param array $options
     * @return string mixed
     */
    public function process($dom, $options)
    {
        $crawler = new Crawler($dom);

        $articles = $crawler->filter('item')->each(function (Crawler $parentCrawler, $i) use ($options) {

            $article = $options['itemTemplate'];
            $fields = ['title', 'link', 'description', 'pubDate', 'guid'];

            foreach ($fields as $field) {
                $node = $parentCrawler->filter($field)->first();

                if (!sizeof($node)) {
                    continue;
                }
                $value = $node->first()->text();
                $marker = '###' . strtoupper($field) . '###';

                $article = str_replace($marker, $value, $article);
            }

            return $article;
        });

        $articles = implode('', $articles);

        $articles = str_replace('|', $articles, $options['wrap']);

        return $articles;
    }
}
