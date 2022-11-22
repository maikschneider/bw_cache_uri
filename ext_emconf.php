<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'DOM Downloader',
    'description' => 'Download and save data from URI. Use post processors to modify the fetched content.',
    'category' => 'extension',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-11.99.99',
            'scheduler' => '9.5.0-11.99.99'
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
    'author_email' => 'maik.schneider@xima.de',
    'author_company' => 'XIMA Media GmbH',
    'version' => '1.1.4'
];
