<?php

defined('TYPO3_MODE') || die();

// Register hook to set sorting field
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['bw_guild'] = 'Blueways\\BwCacheUri\\Hooks\\TCEmainHook';
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['bw_guild'] = 'Blueways\\BwCacheUri\\Hooks\\TCEmainHook';
