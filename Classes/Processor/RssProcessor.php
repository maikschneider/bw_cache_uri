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

            // get texts
            foreach ($fields as $field) {
                $node = $parentCrawler->filter($field)->first();

                if (!sizeof($node)) {
                    continue;
                }
                $fields[$field] = $node->first()->text();
            }

            // add + format date
            if($fields['pubDate'] && $options['dateFormat']) {
                $date = new \DateTime($fields['pubDate']);
                $fields['date'] = $date->format($options['dateFormat']);
            }

            // replace marker
            foreach ($fields as $field => $value) {
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
