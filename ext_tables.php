<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('bw_cache_uri',
            'Configuration/TypoScript', 'DOM Downloader');
    }
);
