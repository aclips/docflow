<?php

namespace Aclips\Docflow;

abstract class BusinessProcess
{
    const SUPPORTED_DOCUMENT_TYPE = null;

    protected Document $document;

    public function getNextTasks(): array
    {
        $tasks = [];
        return $tasks;
    }

    public function getCurrentTasks(): array
    {
        $tasks = [];
        return $tasks;
    }

    /**
     * @param Document $document
     * @return bool
     */
    public static function isSupported(Document $document): bool
    {
        $type = $document->getType();

        return $type === self::SUPPORTED_DOCUMENT_TYPE;
    }

    public function setDocument(Document $document)
    {
        $this->document = $document;
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    abstract public function run();
}