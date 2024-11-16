<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name=Block::TABLE_NAME)
 */
class Block implements BlockInterface
{
    public const TABLE_NAME = _DB_PREFIX_ . 'prettyblocks_block';

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected string $id;

    /**
     * @ORM\Column(type="string")
     */
    protected string $blockId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $template;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $position;

    /**
     * @ORM\Column(type="json")
     */
    protected array $fields = [];

    /**
     * @ORM\ManyToOne(targetEntity="PrestaSafe\PrettyBlocks\Entity\Zone", inversedBy="blocks")
     * @ORM\JoinColumn(nullable=false)
     */
    protected ?Zone $zone = null;

    public function getBlockId(): string
    {
        return $this->blockId;
    }

    public function setBlockId(string $blockId): BlockInterface
    {
        $this->blockId = $blockId;
        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields(array $fields): BlockInterface
    {
        $this->fields = $fields;
        return $this;
    }

    public function getZone(): Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): BlockInterface
    {
        $this->zone = $zone;
        return $this;
    }

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): BlockInterface
    {
        $this->label = $label;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): BlockInterface
    {
        $this->position = $position;

        return $this;
    }

    public function setId(mixed $id): BlockInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): string
    {
        return 'block';
    }

    public function setSlug(string $slug): Block
    {
        $this->slug = $slug;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setTemplate(string $template): BlockInterface
    {
        $this->template = $template;
        return $this;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}
