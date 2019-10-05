<?php

use Blueways\BwCacheUri\Task\DomParserTask;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

defined('TYPO3_MODE') || die();

// Register hook to set sorting field
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['bw_guild'] = 'Blueways\\BwCacheUri\\Hooks\\TCEmainHook';
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['bw_guild'] = 'Blueways\\BwCacheUri\\Hooks\\TCEmainHook';

// Register scheduler task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][DomParserTask::class] = array(
    'extension' => 'bw_cache_uri',
    'title' => 'LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:task.name',
    'description' => 'LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:task.description'
);
