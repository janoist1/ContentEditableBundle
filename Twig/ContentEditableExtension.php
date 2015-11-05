<?php

namespace Ist1\ContentEditableBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use \Twig_Environment as Twig;
use Doctrine\ORM\EntityManagerInterface;
use Ist1\EditableBundle\Entity\Editable;

/**
 * Class EditableExtension
 * @package Ist1EditableBundle\Twig
 */
class ContentEditableExtension extends \Twig_Extension
{
    /** @var array */
    private $configuration;

    /**
     * @param array $configuration
     */
    function __construct($configuration = [])
    {
        $this->configuration = $configuration;
    }

    /**
     * @param string $configKey
     * @param string $objectId
     * @param string $dataField
     * @return string
     * @throws \Exception
     */
    public function contentEditable($configKey, $objectId, $dataField = null)
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

        return 'data-content-editable-config-key="' . $configKey . '" data-content-editable-object-id="' . $objectId . '" data-content-editable-data-field="' . $dataField . '"';
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('content_editable', [$this, 'contentEditable'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'content_editable_extension';
    }
}