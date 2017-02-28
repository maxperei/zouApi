<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Citation;
use AppBundle\Form\CitationType;

class CitationController extends FOSRestController
{
    /**
     * Get an Citation for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Citation",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Citation is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Citation:show.html.twig",
     *  templateVar="citation"
     * )
     *
     * @param int $id the Citation id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Citation not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $citation = $em->getRepository('AppBundle:Citation')->find($id);

        if (!$citation) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $citation;
    }

    /**
     * Get all Citations.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Citation:index.html.twig",
     *  templateVar="citations"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $citations = $em->getRepository('AppBundle:Citation')->findAll();

        return $citations;
    }

    /**
     * Create a new Citation from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\CitationType",
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
        $citation = new Citation();

        $form = $this->createForm(new CitationType(), $citation);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($citation);
            $em->flush();

            $routeOptions = array(
                'id' => $citation->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_citation', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Citation from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\CitationType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Citation is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Citation id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Citation not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $citation = $em->getRepository('AppBundle:Citation')->find($id);

        if (!$citation) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new CitationType(), $citation);
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
     * Delete a Citation for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\CitationType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Citation is not found"
     *   }
     * )
     *
     * @param int $id the Citation id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Citation not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $citation = $em->getRepository('AppBundle:Citation')->find($id);

        if (!$citation) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($citation);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}