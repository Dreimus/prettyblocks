<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Install;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Evolutive\Library\Install\AbstractInstaller;
use Evolutive\Library\Tab\TabCollection;
use Exception;
use Module;
use PrestaSafe\PrettyBlocks\Entity\Block;
use PrestaSafe\PrettyBlocks\Entity\Zone;
use PrestaSafe\PrettyBlocks\Exception\CannotInstallPrettyBlocksException;
use PrestaSafe\PrettyBlocks\FieldType\Registry\FieldTypeElementRegistry;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShopBundle\Translation\TranslatorInterface;

class Installer extends AbstractInstaller
{
    protected FieldTypeElementRegistry $elementRegistry;

    public function __construct(TranslatorInterface $translator, Connection $connection)
    {
        parent::__construct($translator, $connection);
        $this->elementRegistry = new FieldTypeElementRegistry();
    }

    public function getHooks(): array
    {
        return [
            'actionDispatcher',
        ];
    }

    /**
     * If you want to add tabs to the back office, you can do it here.
     * Note that if you use a ParentTab, it will create tabs un page, if not, it will create a new sidebar menu.
     *
     * @return TabCollection
     */
    public function getTabs(): TabCollection
    {
        return new TabCollection();
    }

    /**
     * @throws CannotInstallPrettyBlocksException
     */
    public function install(Module $module): bool
    {
        return
            parent::install($module) &&
            $this->registerDoctrineNamespace() &&
            $this->installSchema() &&
            $this->installFixture();
    }

    public function uninstall(Module $module): bool
    {
        return
            $this->uninstallSchema() &&
            parent::uninstall($module);
    }

    /**
     * Install the schema for Doctrine entities
     *
     * @throws CannotInstallPrettyBlocksException
     */
    protected function installSchema(): bool
    {
        $entityManager = $this->getEntityManager();

        $tool = new SchemaTool($entityManager);

        try {
            $classMetaData = $this->getClasses($entityManager);

            $tool->createSchema($classMetaData);
        } catch (Exception $e) {
            throw new CannotInstallPrettyBlocksException($e->getMessage());
        }

        return true;
    }

    protected function registerDoctrineNamespace(): bool
    {
        $entityManager = $this->getEntityManager();
        $config = $entityManager->getConfiguration();

        $annotationDriver = new AnnotationDriver(
            new AnnotationReader(),
            [dirname(__DIR__, 2) . '/src/Entity']
        );

        ($config->getMetadataDriverImpl())->addDriver($annotationDriver, 'PrestaSafe\PrettyBlocks\Entity');

        return true;
    }

    public function getClasses(EntityManager $entityManager): array
    {
        return [
            $entityManager->getClassMetadata(Zone::class),
            $entityManager->getClassMetadata(Block::class),
        ];
    }

    /**
     * Uninstall the schema (drop tables)
     *
     * @throws CannotInstallPrettyBlocksException
     */
    protected function uninstallSchema(): bool
    {
        $this->registerDoctrineNamespace();
        $entityManager = $this->getEntityManager();

        $tool = new SchemaTool($entityManager);

        $classMetaData = $this->getClasses($entityManager);

        try {
            $tool->dropSchema($classMetaData);
        } catch (Exception $e) {
            throw new CannotInstallPrettyBlocksException($e->getMessage());
        }

        return true;
    }

    /**
     * Get the Doctrine Entity Manager
     */
    protected function getEntityManager(): object
    {
        return (SymfonyContainer::getInstance())->get('doctrine.orm.entity_manager');
    }

    private function installFixture(): bool
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        try {
            $em->persist(
                (new Zone())
                    ->setLabel('Blocs génériques')
                    ->setReference(Zone::GENERIC_ZONE_REFERENCE)
            );
            $em->persist(
                (new Zone())
                    ->setLabel('Sur-entête')
                    ->setReference('header_top')
            );
            $em->persist(
                (new Zone())
                    ->setLabel('Entête')
                    ->setReference('header')
            );
            $em->persist(
                (new Zone())
                    ->setLabel('Pied de page')
                    ->setReference('footer')
            );

            $em->flush();
        } catch (ORMException $e) {
            throw new CannotInstallPrettyBlocksException($e->getMessage());
        }

        return true;
    }
}
