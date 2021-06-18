<?php

namespace Aclips\Docflow;

class Document
{
    protected $id;

    protected string $type;

    protected array $fields = [];

    public function getType(): string
    {
        return $this->type;
    }

    public function getField($code)
    {
        return $this->fields[$code] ?? null;
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function setField(string $code, $value)
    {
        $this->fields[$code] = $value;
    }


}

