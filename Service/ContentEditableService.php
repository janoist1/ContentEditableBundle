<?php

namespace Ist1\ContentEditableBundle\Service;


use Doctrine\ORM\EntityManagerInterface;

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
     * @throws \Exception
     */
    public function updateEntity($configKey, $objectId, $value, $dataField = null)
    {
        if (!array_key_exists($configKey, $this->configuration['configurations'])) {
            throw new \Exception('Missing configuration "' . $configKey . '"');
        }

        $config = $this->configuration['configurations'][$configKey];

        if ($dataField == null) {
            if (!array_key_exists('data_field', $config)) {
                throw new \Exception('Missing data_field');
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
            throw new \Exception('No setter "' . $setter . '" found for "' . get_class($entity) . '"');
        }

        $entity->$setter(trim($value));

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
} 