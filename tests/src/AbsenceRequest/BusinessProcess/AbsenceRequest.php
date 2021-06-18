<?php

namespace Aclips\Docflow\Tests\BusinessProcess;

use Aclips\Docflow;

class AbsenceRequest extends Docflow\BusinessProcess
{
    const SUPPORTED_DOCUMENT_TYPE = 'AbsenceRequest';

    public function run()
    {
        $document = $this->getDocument();

        $status = $document->getField('status');

        if ($status === null) {
            $document->setField('status', 'process');
            //@todo создать задачи
        }
    }
}