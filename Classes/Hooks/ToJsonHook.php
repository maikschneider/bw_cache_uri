<?php

namespace Blueways\BwCacheUri\Hooks;

class ToJsonHook implements DomPostProcessorInterface
{

    /**
     * @param string $dom
     * @return string mixed
     */
    public function process($dom)
    {
        // TODO: Implement process() method.
        \TYPO3\CMS\Core\Utility\DebugUtility::debug($dom, 'Debug: ' . __FILE__ . ' in Line: ' . __LINE__);
    }
}
