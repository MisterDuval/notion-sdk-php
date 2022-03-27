<?php

declare(strict_types=1);

namespace Brd6\NotionSdkPhp\Resource\Page\PropertyValue;

use Brd6\NotionSdkPhp\Resource\Page\AbstractPropertyValue;

class CheckboxPropertyValue extends AbstractPropertyValue
{
    protected bool $checkbox = false;

    protected function initialize(): void
    {
        $data = (array) $this->getRawData()[$this->getType()];
        $this->checkbox = (bool) $data['checkbox'];
    }

    public function getCheckbox(): bool
    {
        return $this->checkbox;
    }

    public function setCheckbox(bool $checkbox): self
    {
        $this->checkbox = $checkbox;

        return $this;
    }
}
