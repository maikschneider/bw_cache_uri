<?php

namespace Blueways\BwCacheUri\Processor;

use Exception;
use Symfony\Component\DomCrawler\Crawler;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class RssProcessor implements PostProcessorInterface
{
    public function __construct()
    {
        if (!class_exists('\Symfony\Component\DomCrawler\Crawler')) {
            @include 'phar://' . ExtensionManagementUtility::extPath('bw_cache_uri') . 'Libraries/symfony-dom-crawler.phar/vendor/autoload.php';
        }
    }

    /**
     * @param string $dom
     * @param array $options
     * @return string mixed
     * @throws Exception
     */
    public function process($dom, $options)
    {
        $crawler = new Crawler($dom);

        $articles = $crawler->filter('item')->each(function (Crawler $parentCrawler, $i) use ($options) {

            $article = $options['itemTemplate'];
            $fields = [];

            $children = $parentCrawler->filter('item')->children();
            foreach ($children as $key => $node) {
                $fields[$node->tagName] = $node->nodeValue;
            }

            // add + format date
            if ($fields['pubDate'] && $options['dateFormat']) {
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
