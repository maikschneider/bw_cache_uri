<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {

    // A - Register typoscript template
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('bw_cache_uri',
        'Configuration/TypoScript', 'DOM Downloader');

    // B - Read TypoScript and add DOM processors
    $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    $configurationManager = $objectManager->get(ConfigurationManager::class);
    $typoscript = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

    if (isset($typoscript['plugin.']['tx_bwcacheuri.'])) {
        foreach ($typoscript['plugin.']['tx_bwcacheuri.']['settings.']['postProcessors.'] as $class => $postProcessor) {
            $GLOBALS['TCA']['tt_content']['columns']['dom_processor']['config']['items'][] = [
                $postProcessor['label'],
                substr($class, 0, -1)
            ];
        }
    }
}   );
