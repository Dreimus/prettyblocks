<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use PrestaSafe\PrettyBlocks\Collection\BlockCollection;
use PrestaShop\PrestaShop\Core\Exception\TypeException;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name=Zone::TABLE_NAME,
 *     indexes={
 *         @ORM\Index(name="reference", columns={"reference"})
 *     }
 *     )
 */
class Zone
{
    public const TABLE_NAME = _DB_PREFIX_ . 'prettyblocks_zone';
    public const TABLE_BLOCK_NAME = _DB_PREFIX_ . 'prettyblocks_zone_block';
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected string $id = '';

    /**
     * @ORM\Column(type="string")
     */
    protected string $label;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected string $reference;

    /**
     * @var Collection<int, Block>
     * @ORM\OneToMany(
     *     targetEntity="PrestaSafe\PrettyBlocks\Entity\Block",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true,
     *     mappedBy="zone"
     * )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private Collection $blocks;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
        $this->id = (Uuid::v6())->toRfc4122();
    }

    /**
     * Return the ID of the zone
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Return the label of the zone
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Return the collection of elements in the zone
     *
     * @throws TypeException
     *
     * @return Collection<int, Block>
     */
    public function getBlocks(): Collection
    {
        return new BlockCollection($this->blocks->getValues());
    }

    /**
     * Add an element to the zone
     */
    public function addBlock(BlockInterface $block, int $position): void
    {
        $block->setPosition($position);
        $this->blocks->add($block);
    }

    /**
     * Remove an element from the zone
     */
    public function removeBlock(BlockInterface $block): self
    {
        if ($this->blocks->removeElement($block)) {
            if ($block->getZone() === $this) {
                $block->setZone(null);
            }
        }

        return $this;
    }

    /**
     * Remove all elements from the zone
     */
    public function removeAllElements(): void
    {
        foreach ($this->blocks as $element) {
            $this->removeBlock($element);
        }
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setLabel(string $label): Zone
    {
        $this->label = $label;
        return $this;
    }

    public function setReference(string $reference): Zone
    {
        $this->reference = $reference;
        return $this;
    }
}
