<?php

namespace Ist1\ContentEditableBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Ist1\ContentEditableBundle\Exception\ContentEditableException;


class ContentEditableService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var array */
    private $configuration;

    /**
     * @param EntityManagerInterface $entityManager
     * @param array $configuration
     */
    function __construct(EntityManagerInterface $entityManager, $configuration = [])
    {
        $this->entityManager = $entityManager;
        $this->configuration = $configuration;
    }

    /**
     * @param $configKey
     * @param $objectId
     * @param $value
     * @param null|string $dataField
     * @throws ContentEditableException
     */
    public function updateEntity($configKey, $objectId, $value, $dataField = null)
    {
        if (!array_key_exists($configKey, $this->configuration['configurations'])) {
            throw new ContentEditableException('Missing configuration "' . $configKey . '"');
        }

        $config = $this->configuration['configurations'][$configKey];

        if ($dataField == null) {
            if (!array_key_exists('data_field', $config)) {
                throw new ContentEditableException('Missing data_field');
            }

            $dataField = $config['data_field'];
        }

        $idField = 'id';
        if (array_key_exists('id_field', $config)) {
            $idField = $config['id_field'];
        }

        $repository = $this->entityManager->getRepository($config['repository_class']);
        $entity = $repository->findOneBy(
            [$idField => $objectId]
        );
        $setter = 'set' . ucfirst($dataField);

        if (!method_exists($entity, $setter)) {
            throw new ContentEditableException('No setter "' . $setter . '" found for "' . get_class($entity) . '"');
        }

        $entity->$setter(trim($value));

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
} 