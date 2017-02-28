<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Advice;
use AppBundle\Form\AdviceType;

class AdviceController extends FOSRestController
{
    /**
     * Get an Advice for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Advice",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Advice is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Advice:show.html.twig",
     *  templateVar="advice"
     * )
     *
     * @param int $id the Advice id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Advice not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $advice = $em->getRepository('AppBundle:Advice')->find($id);

        if (!$advice) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $advice;
    }

    /**
     * Get all Advices.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Advice:index.html.twig",
     *  templateVar="advices"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $advices = $em->getRepository('AppBundle:Advice')->findAll();

        return $advices;
    }

    /**
     * Create a new Advice from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\AdviceType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postAction(Request $request)
    {
        $advice = new Advice();

        $form = $this->createForm(new AdviceType(), $advice);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($advice);
            $em->flush();

            $routeOptions = array(
                'id' => $advice->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_advice', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Advice from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\AdviceType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Advice is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Advice id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Advice not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $advice = $em->getRepository('AppBundle:Advice')->find($id);

        if (!$advice) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new AdviceType(), $advice);
        $form->submit($request);

        if ($form->isValid()) {
            $em->flush();

            $statusCode = Response::HTTP_NO_CONTENT;
            $response = new Response();
            $response->setStatusCode($statusCode);

            return $response;
        } else {

        }

        return $form;

    }

    /**
     * Delete a Advice for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\AdviceType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Advice is not found"
     *   }
     * )
     *
     * @param int $id the Advice id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Advice not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $advice = $em->getRepository('AppBundle:Advice')->find($id);

        if (!$advice) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($advice);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}