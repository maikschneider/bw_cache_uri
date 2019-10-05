<?php
defined('TYPO3_MODE') or die();

// 1. Define new fields
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
    ]
);

// 2. Register new fields
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $temporaryColumns
);

// 3. Add new palette to HTML tt_content type
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--palette--;LLL:EXT:bw_cache_uri/Resources/Private/Language/locallang.xlf:palette.tca.palette;parsing_options',
    'html',
    'after:header'
);

// 4. Show palette
$GLOBALS['TCA']['tt_content']['palettes']['parsing_options'] = [
    'showitem' => 'dom_uri,--linebreak--,dom_filter'
];
