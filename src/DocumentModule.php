<?php

namespace Aclips\Docflow;

use Service\EntityManagerInterface;

class DocumentModule
{
    protected EntityManagerInterface $entityManager;

    protected array $config;

    public function __construct(EntityManagerInterface $entityManager, array $config)
    {
        $this->config = $config;
    }

    public function createDocument(array $fields): Document
    {
        $document = new Document();
        $document->setFields($fields);

        //@todo validate
        $entityManager->save($document);

        $businessProcessClasses = $this->getDocumentBusinessProcessClasses($document);

        foreach ($businessProcessClasses as $businessProcessClass) {
            $businessProcess = new $businessProcessClass;
            $businessProcess->setDocument($document);
            $businessProcess->run();
        }

        return $document;
    }

    /**
     * @param Document $document
     * @return array
     */
    public function getDocumentBusinessProcessClasses(Document $document): array
    {
        $businessProcessClasses = [];

        foreach ($this->config as $className => $element) {
            $filter = $element['filter'];

            $isSupported = false;

            if (!empty($filter)) {
                if (is_callable($filter)) {
                    $isSupported = $filter($document);
                } elseif (is_array($filter) && count($filter) == 2) {
                    $isSupported = call_user_func($filter, $document);
                } elseif (array_key_exists('type', $filter)) {
                    $isSupported = $document->getType() == $filter['type'];
                }

                if ($isSupported === true) {
                    $businessProcessClasses[] = $className;
                }
            }

        }

        return $businessProcessClasses;
    }
}
