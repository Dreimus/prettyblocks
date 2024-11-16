<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component;

use PrestaSafe\PrettyBlocks\FieldType\Element\AbstractElementFieldType;

abstract class AbstractComponentFieldType extends AbstractElementFieldType implements ComponentFieldTypeInterface
{
    protected bool $isRepeatable;
    protected int $depth = 1;
    protected string $slug = 'undefined_component';
    protected string $template = 'module:prettyblocks/templates/element/component/undefined_component.tpl';

    abstract public function isRepeatable(): bool;

    public function getType(): string
    {
        return 'component';
    }

    public function setRepeatable(bool $repeatable): ComponentFieldTypeInterface
    {
        $this->isRepeatable = $repeatable;

        return $this;
    }

    public function getDepth(): int
    {
        return $this->depth;
    }

    public function setDepth(int $depth): AbstractComponentFieldType
    {
        $this->depth = $depth;
        return $this;
    }


}
