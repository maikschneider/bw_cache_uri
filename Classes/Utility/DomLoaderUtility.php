<?php

namespace Blueways\BwCacheUri\Utility;

use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class DomLoaderUtility
{

    protected $uri;

    protected $dom;

    protected $filter;

    protected function loadDom()
    {
        $client = HttpClient::create();
        try {
            $response = $client->request('GET', $this->uri);
            $this->dom = $response->getContent();
        } catch (TransportExceptionInterface $e) {
        } catch (ClientExceptionInterface $e) {
        } catch (RedirectionExceptionInterface $e) {
        } catch (ServerExceptionInterface $e) {
        }
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param mixed $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function crawlDom()
    {
        if (!$this->filter) {
            return;
        }

        $crawler = new Crawler($this->dom);
        $crawler = $crawler->filter($this->filter);
        $this->dom = $crawler->html('');
    }

    public function getDomFromUri($uri)
    {
        $this->uri = $uri;

        $this->loadDom();
        $this->crawlDom();

        return $this->dom;
    }
}
