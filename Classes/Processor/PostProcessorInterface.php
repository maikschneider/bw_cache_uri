<?php

namespace Blueways\BwCacheUri\Processor;

interface PostProcessorInterface {

    /**
     * @param string $dom
     * @param array $options
     * @return string mixed
     */
    public function process($dom, $options);
}
