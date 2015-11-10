<?php

namespace Ist1\ContentEditableBundle\Tests\Builder;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Yaml\Parser;
use Ist1\ContentEditableBundle\Service\ContentEditableService;
use Ist1\ContentEditableBundle\Tests\TestCase;


class ContentEditableServiceTest extends TestCase
{
    const CONFIG_YML = 'Fixtures/config.yml';

    /**
     * Test update of a regular every day normal entity
     */
    public function testUpdateEntityBlog()
    {
        $id = 1;
        $config = 'blog';
        $dataField = 'content';
        $newValue = 'new value';
        $configs = $this->loadConfigurations();
        $setter = 'set' . ucfirst($dataField);

        $mockBlogEntity = $this->getMockBuilder('Acme\BlogBundle\Entity\Blog')
            ->setMethods([$setter])
            ->getMock();
        $mockBlogEntity->expects($this->once())
            ->method($setter)
            ->with($newValue);

        $mockRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $mockRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $id])
            ->will($this->returnValue($mockBlogEntity));

        $mockEntityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $mockEntityManager->expects($this->once())
            ->method('getRepository')
            ->with($configs['configurations'][$config]['repository_class'])
            ->will($this->returnValue($mockRepository));
        $mockEntityManager->expects($this->once())
            ->method('persist');
        $mockEntityManager->expects($this->once())
            ->method('flush');

        $service = new ContentEditableService($mockEntityManager, $configs);

        $service->updateEntity($config, $id, $newValue, $dataField);
    }

    /**
     * @return array
     */
    private function loadConfigurations()
    {
        $yaml = new Parser();

        return $yaml->parse(file_get_contents(__DIR__ . '/' . self::CONFIG_YML))['ist1_content_editable'];
    }
}