<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\MediaEvent;
use AppBundle\Form\MediaEventType;

class MediaEventController extends FOSRestController
{
    /**
     * Get an Media Event for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\MediaEvent",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Media Event is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:MediaEvent:show.html.twig",
     *  templateVar="mediaEvent"
     * )
     *
     * @param int $id the MediaEvent id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Media Event not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaEvent = $em->getRepository('AppBundle:MediaEvent')->find($id);

        if (!$mediaEvent) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $mediaEvent;
    }

    /**
     * Get all Media Events.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:MediaEvent:index.html.twig",
     *  templateVar="mediaEvents"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaEvents = $em->getRepository('AppBundle:MediaEvent')->findAll();

        return $mediaEvents;
    }

    /**
     * Create a new Media Event from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\MediaEventType",
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
        $mediaEvent = new MediaEvent();

        $form = $this->createForm(new MediaEventType(), $mediaEvent);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($mediaEvent);
            $em->flush();

            $routeOptions = array(
                'id' => $mediaEvent->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_mediaevent', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Media Event from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\MediaEventType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Media Event is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the MediaEvent id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when MediaEvent not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaEvent = $em->getRepository('AppBundle:MediaEvent')->find($id);

        if (!$mediaEvent) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new MediaEventType(), $mediaEvent);
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
     * Delete a Media Event for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\MediaEventType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Media Event is not found"
     *   }
     * )
     *
     * @param int $id the MediaEvent id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Media Event not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaEvent = $em->getRepository('AppBundle:MediaEvent')->find($id);

        if (!$mediaEvent) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($mediaEvent);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}