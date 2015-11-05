<?php

namespace Ist1\ContentEditableBundle\Controller;

use Ist1\ContentEditableBundle\Service\ContentEditableService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class ContentEditableController extends Controller
{
    /**
     * @Route("/{configKey}/{objectId}", name="content_editable_update")
     * @Method("PUT")
     *
     * @param $configKey
     * @param $objectId
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function updateAction($configKey, $objectId, Request $request)
    {
        $dataField = $request->get('dataField', null);

        /** @var ContentEditableService $service */
        $service = $this->get('ist1.content_editable.service');

        $service->updateEntity($configKey, $objectId, $request->getContent(), $dataField);

        return new Response();
    }
}
