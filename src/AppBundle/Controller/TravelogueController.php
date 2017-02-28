<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Travelogue;
use AppBundle\Form\TravelogueType;

class TravelogueController extends FOSRestController
{
    /**
     * Get an Travelogue for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Travelogue",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Travelogue is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Travelogue:show.html.twig",
     *  templateVar="travelogue"
     * )
     *
     * @param int $id the Travelogue id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Travelogue not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $travelogue = $em->getRepository('AppBundle:Travelogue')->find($id);

        if (!$travelogue) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $travelogue;
    }

    /**
     * Get all Travelogues.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Travelogue:index.html.twig",
     *  templateVar="travelogues"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $travelogues = $em->getRepository('AppBundle:Travelogue')->findAll();

        return $travelogues;
    }

    /**
     * Create a new Travelogue from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\TravelogueType",
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
        $travelogue = new Travelogue();

        $form = $this->createForm(new TravelogueType(), $travelogue);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($travelogue);
            $em->flush();

            $routeOptions = array(
                'id' => $travelogue->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_travelogue', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Travelogue from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\TravelogueType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Travelogue is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Travelogue id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Travelogue not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $travelogue = $em->getRepository('AppBundle:Travelogue')->find($id);

        if (!$travelogue) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new TravelogueType(), $travelogue);
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
     * Delete a Travelogue for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\TravelogueType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Travelogue is not found"
     *   }
     * )
     *
     * @param int $id the Travelogue id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Travelogue not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $travelogue = $em->getRepository('AppBundle:Travelogue')->find($id);

        if (!$travelogue) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($travelogue);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}