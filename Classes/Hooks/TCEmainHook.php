<?php

namespace Blueways\BwCacheUri\Hooks;

class TCEmainHook
{

    public function processDatamap_preProcessFieldArray(
        &$fieldArray,
        $table,
        $id,
        $dataHandler
    ) {
        // @TODO check of new entry (no $id)
        if ($table === 'tt_content' && $id && $dataHandler->datamap['tt_content'][$id]['CType'] === 'html' && $dataHandler->datamap['tt_content'][$id]['dom_uri'] !== "") {
            // @TODO start parser, save dom
        }
    }
}
