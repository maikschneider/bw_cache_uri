<?php

namespace Blueways\BwCacheUri\Task;

use Blueways\BwCacheUri\Utility\DomLoaderUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

class DomParserTask extends AbstractTask
{

    public function execute()
    {
        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');

        /** @var DomLoaderUtility $domLoader */
        $domLoader = GeneralUtility::makeInstance(DomLoaderUtility::class);

        // find all html elements with parse uri
        $statement = $queryBuilder
            ->select('uid', 'dom_uri', 'dom_filter', 'dom_processor', 'bodytext')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->neq('dom_uri', $queryBuilder->createNamedParameter(''))
            )
            ->execute();

        while ($row = $statement->fetch()) {

            $domLoader->setFilter($row['dom_filter']);
            $domLoader->setProcessor($row['dom_processor']);
            $html = $domLoader->getDomFromUri($row['dom_uri']);

            $queryBuilder
                ->update('tt_content')
                ->set('bodytext', $html)
                ->where(
                    $queryBuilder->expr()->eq('uid', $row['uid'])
                )
                ->execute();
        }

        return true;
    }
}
