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

            $domLoader = GeneralUtility::makeInstance(DomLoaderUtility::class);
            $html = $domLoader->getDomFromUri($uri);

            if ($html !== '') {

                $fieldArray['bodytext'] = $html;

                $flashMessageService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
                $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(FlashMessage::class,
                    'LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:message.success.body',
                    'LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:message.success.title',
                    FlashMessage::OK,
                    true
                );
                $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
                $messageQueue->addMessage($message);
            }
        }
    }
}
