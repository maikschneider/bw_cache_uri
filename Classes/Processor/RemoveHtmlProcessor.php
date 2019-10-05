<?php

namespace Blueways\BwCacheUri\Processor;

class RemoveHtmlProcessor implements PostProcessorInterface
{

    /**
     * @param string $dom
     * @param array $options
     * @return string mixed
     */
    public function process($dom, $options)
    {
        return strip_tags($dom, $options['allowed_tags']);
    }
}
