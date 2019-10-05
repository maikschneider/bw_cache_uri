<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

defined('TYPO3_MODE') or die();

// A - Add new fields to tt_content HTML element

// A1. Define new fields
$temporaryColumns = array(
    'dom_uri' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:tca.uri',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputLink',
            'size' => 50,
            'max' => 1024,
            'eval' => 'trim',
            'fieldControl' => [
                'linkPopup' => [
                    'options' => [
                        'title' => 'LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:tca.uri',
                        'blindLinkOptions' => 'file,mail,page,spec,telephone,folder',
                        'blindLinkFields' => 'class,params,target,title'
                    ],
                ],
            ],
            'softref' => 'typolink'
        ]
    ],
    'dom_filter' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:tca.filter',
        'config' => [
            'type' => 'input',
            'size' => 50,
            'max' => 1024
        ]
    ],
    'dom_processor' => [
        'exclude' => true,
        'label' => 'LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:tca.processor',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:tca.hooks.none', '']
            ]
        ]
    ]
);

// A - Read TypoScript
$configurationManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
$typoscript = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

// Add items to dom_processor
if (isset($typoscript['plugin.']['tx_bwcacheuri.'])) {
    foreach ($typoscript['plugin.']['tx_bwcacheuri.']['settings.']['postProcessors.'] as $class => $postProcessor) {
        $temporaryColumns['dom_processor']['config']['items'][] = [
            $postProcessor['label'],
            substr($class, 0, -1)
        ];
    }
}

// A2. Register new fields
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $temporaryColumns
);

// A3. Add new palette to HTML tt_content type
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--palette--;LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:tca.palette;parsing_options',
    'html',
    'after:bodytext'
);

// A4. Show palette
$GLOBALS['TCA']['tt_content']['palettes']['parsing_options'] = [
    'showitem' => 'dom_uri,--linebreak--,dom_filter,--linebreak--,dom_processor'
];
