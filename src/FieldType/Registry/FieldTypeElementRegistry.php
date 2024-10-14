<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Registry;

use Doctrine\Common\Collections\ArrayCollection;
use Hook;
use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\Exception\CannotExecRegisterBlockHookException;
use PrestaSafe\PrettyBlocks\Exception\InvalidElementRegistrationException;
use PrestaSafe\PrettyBlocks\FieldType\Element\Block\BlockFieldTypeInterface;
use PrestaSafe\PrettyBlocks\FieldType\Element\Block\NavigationMenu;
use PrestaSafe\PrettyBlocks\FieldType\Element\ElementFieldTypeInterface;
use PrestaSafe\PrettyBlocks\FieldType\FieldTypeInterface;
use PrestaShop\PrestaShop\Core\Exception\TypeException;
use PrestaShopException;

class FieldTypeElementRegistry
{
    private FieldTypeCollection $fieldTypes;
    private ArrayCollection $doctrineElementSubclasses;

    public function __construct()
    {
        $this->fieldTypes = new FieldTypeCollection();
        $this->doctrineElementSubclasses = new ArrayCollection();
    }

    /**
     * Allows to register a field type class
     *
     * @param string $fieldTypeClassName
     *
     * @throws InvalidElementRegistrationException|TypeException
     *
     * @return FieldTypeElementRegistry
     */
    public function add(string|FieldTypeInterface $fieldType): self
    {
        if (!is_object($fieldType)) {
            // checking if the field type class exists and is a subclass of FieldTypeInterface
            if (!class_exists($fieldType) ||
                !is_subclass_of($fieldType, ElementFieldTypeInterface::class)) {
                throw new InvalidElementRegistrationException(
                    sprintf(
                        'Field type class %s does not exist or is not a subclass of ElementFieldTypeInterface',
                        $fieldType
                    )
                );
            }

            $fieldType = new $fieldType();
        }

        if ($fieldType instanceof ElementFieldTypeInterface) {
            if ($fieldType instanceof BlockFieldTypeInterface) {
                $this->fieldTypes->add($fieldType);
            }

            if ($fieldType->getDataClass() && !$this->doctrineElementSubclasses->contains($fieldType->getDataClass())) {
                $this->doctrineElementSubclasses->add($fieldType->getDataClass());
            }

            foreach ($fieldType->getFields() as $componentFieldType) {
                $this->add($componentFieldType);
            }
        }

        return $this;
    }

    /**
     * @throws CannotExecRegisterBlockHookException|InvalidElementRegistrationException
     * @throws TypeException
     */
    public function getRegisteredFieldTypes(): FieldTypeCollection
    {
        try {
            Hook::exec('actionRegisterBlock', ['element_registry' => $this]);
        } catch (PrestashopException $e) {
            throw new CannotExecRegisterBlockHookException($e->getMessage());
        }

        //$this->registerNativeElements();

        return $this->fieldTypes;
    }

    /**
     * @throws InvalidElementRegistrationException
     * @throws TypeException
     */
    public function registerNativeElements(): void
    {
        $this->add(NavigationMenu::class);
    }

    public function getDoctrineElementSubclasses(): ArrayCollection
    {
        if ($this->doctrineElementSubclasses->isEmpty()) {
            $this->registerNativeElements();
        }

        return $this->doctrineElementSubclasses;
    }
}
