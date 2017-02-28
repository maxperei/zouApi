<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Participant;
use AppBundle\Form\ParticipantType;

class ParticipantController extends FOSRestController
{
    /**
     * Get an Participant for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Participant",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Participant is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Participant:show.html.twig",
     *  templateVar="participant"
     * )
     *
     * @param int $id the Participant id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Participant not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $participant = $em->getRepository('AppBundle:Participant')->find($id);

        if (!$participant) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $participant;
    }

    /**
     * Get all Participants.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Participant:index.html.twig",
     *  templateVar="participants"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $participants = $em->getRepository('AppBundle:Participant')->findAll();

        return $participants;
    }

    /**
     * Create a new Participant from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ParticipantType",
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
        $participant = new Participant();

        $form = $this->createForm(new ParticipantType(), $participant);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();

            $routeOptions = array(
                'id' => $participant->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_participant', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Participant from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ParticipantType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Participant is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Participant id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Participant not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $participant = $em->getRepository('AppBundle:Participant')->find($id);

        if (!$participant) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new ParticipantType(), $participant);
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
     * Delete a Participant for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ParticipantType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Participant is not found"
     *   }
     * )
     *
     * @param int $id the Participant id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Participant not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $participant = $em->getRepository('AppBundle:Participant')->find($id);

        if (!$participant) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($participant);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}