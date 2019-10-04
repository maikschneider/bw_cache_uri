<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'DOM Downloader',
    'description' => 'Download and cache HTML from URI',
    'category' => 'extension',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.99-9.99.99',
            'fluid_styled_content' => '9.5.4-9.99.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Blueways\\BwCacheUri\\' => 'Classes'
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Maik Schneider',
    'author_email' => 'm.schneider@blueways.de',
    'author_company' => 'blueways',
    'version' => '1.0.0',
];
