<?php

namespace Blueways\BwCacheUri\Hooks;

use Blueways\BwCacheUri\Utility\DomLoaderUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TCEmainHook
{

    public function processDatamap_preProcessFieldArray(
        &$fieldArray,
        $table,
        $id,
        $dataHandler
    ) {
        if ($table === 'tt_content' && $id && $dataHandler->datamap['tt_content'][$id]['CType'] === 'html' && $dataHandler->datamap['tt_content'][$id]['dom_uri'] !== "") {
            $uri = $dataHandler->datamap['tt_content'][$id]['dom_uri'];
            $filter = $dataHandler->datamap['tt_content'][$id]['dom_filter'];

            $domLoader = GeneralUtility::makeInstance(DomLoaderUtility::class);
            $domLoader->setFilter($filter);
            $html = $domLoader->getDomFromUri($uri);

            if ($html !== '') {

                $fieldArray['bodytext'] = $html;

                $flashMessageService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
                $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(FlashMessage::class,
                    $GLOBALS['LANG']->sL('LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:message.success.body'),
                    $GLOBALS['LANG']->sL('LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:message.success.title'),
                    FlashMessage::OK,
                    false
                );
                $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
                $messageQueue->addMessage($message);
            }
        }
    }
}
