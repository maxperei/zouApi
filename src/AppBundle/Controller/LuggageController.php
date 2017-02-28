<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Luggage;
use AppBundle\Form\LuggageType;

class LuggageController extends FOSRestController
{
    /**
     * Get an Luggage for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Luggage",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Luggage is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Luggage:show.html.twig",
     *  templateVar="Luggage"
     * )
     *
     * @param int $id the Luggage id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Luggage not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $luggage = $em->getRepository('AppBundle:Luggage')->find($id);

        if (!$luggage) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $luggage;
    }

    /**
     * Get all Luggages.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Luggage:index.html.twig",
     *  templateVar="Luggages"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $luggages = $em->getRepository('AppBundle:Luggage')->findAll();

        return $luggages;
    }

    /**
     * Create a new Luggage from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\LuggageType",
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
        $luggage = new Luggage();

        $form = $this->createForm(new LuggageType(), $luggage);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($luggage);
            $em->flush();

            $routeOptions = array(
                'id' => $luggage->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_luggage', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Luggage from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\LuggageType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Luggage is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Luggage id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Luggage not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $luggage = $em->getRepository('AppBundle:Luggage')->find($id);

        if (!$luggage) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new LuggageType(), $luggage);
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
     * Delete a Luggage for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\LuggageType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Luggage is not found"
     *   }
     * )
     *
     * @param int $id the Luggage id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Luggage not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $luggage = $em->getRepository('AppBundle:Luggage')->find($id);

        if (!$luggage) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($luggage);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}