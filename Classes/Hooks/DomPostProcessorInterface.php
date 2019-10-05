<?php

namespace Blueways\BwCacheUri\Hooks;

interface DomPostProcessorInterface {

    /**
     * @param string $dom
     * @return string mixed
     */
    public function process($dom);
}
