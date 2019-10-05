<?php

namespace Blueways\BwCacheUri\Utility;

use Blueways\BwCacheUri\Processor\PostProcessorInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class DomLoaderUtility
{

    protected $uri;

    protected $dom;

    protected $filter;

    protected $processor;

    /**
     * @return mixed
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * @param mixed $processor
     */
    public function setProcessor($processor)
    {
        $this->processor = $processor;
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

    public function getDomFromUri($uri)
    {
        $this->uri = $uri;

        $this->loadDom();
        $this->crawlDom();
        $this->processPostProcessor();

        return $this->dom;
    }

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

    public function crawlDom()
    {
        if (!$this->filter || !$this->dom) {
            return;
        }

        $crawler = new Crawler($this->dom);
        $crawler = $crawler->filter($this->filter);
        $this->dom = $crawler->html('');
    }

    protected function processPostProcessor()
    {
        if (!$this->processor) {
            return;
        }

        $processor = GeneralUtility::makeInstance($this->processor);

        if (!$processor instanceof PostProcessorInterface) {
            throw new \RuntimeException('Class "' . $this->processor . '" does not implement Blueways\BwCacheUri\Processor\PostProcessorInterface');
        }

        // get processor options from typoscript
        $configurationManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $typoscript = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $processorOptions = isset($typoscript['plugin.']['tx_bwcacheuri.']) && isset($typoscript['plugin.']['tx_bwcacheuri.']['settings.']['postProcessors.'][$this->processor . '.']['options.']) ? $typoscript['plugin.']['tx_bwcacheuri.']['settings.']['postProcessors.'][$this->processor . '.']['options.'] : [];

        // run processor
        $this->dom = $processor->process($this->dom, $processorOptions);
    }
}
