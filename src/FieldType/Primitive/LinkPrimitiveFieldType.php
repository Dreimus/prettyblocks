<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class LinkPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    protected string $link_label = 'Link Label';
    protected string $link_url = 'https://www.example.com';

    public function getLinkLabel(): string
    {
        return $this->link_label;
    }

    public function setLinkLabel(string $link_label): LinkPrimitiveFieldType
    {
        $this->link_label = $link_label;
        return $this;
    }

    public function getLinkUrl(): string
    {
        return $this->link_url;
    }

    public function setLinkUrl(string $link_url): LinkPrimitiveFieldType
    {
        $this->link_url = $link_url;
        return $this;
    }

    public function getType(): string
    {
        return 'link';
    }

    public function getDefault(): array
    {
        return [
            'label' => $this->getLinkLabel(),
            'href' => $this->getLinkUrl(),
        ];
    }

}
