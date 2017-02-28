<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Outgo;
use AppBundle\Form\OutgoType;

class OutgoController extends FOSRestController
{
    /**
     * Get an Outgo for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Outgo",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Outgo is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Outgo:show.html.twig",
     *  templateVar="outgo"
     * )
     *
     * @param int $id the Outgo id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Outgo not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $outgo = $em->getRepository('AppBundle:Outgo')->find($id);

        if (!$outgo) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $outgo;
    }

    /**
     * Get all Outgos.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Outgo:index.html.twig",
     *  templateVar="outgos"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $outgos = $em->getRepository('AppBundle:Outgo')->findAll();

        return $outgos;
    }

    /**
     * Create a new Outgo from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\OutgoType",
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
        $outgo = new Outgo();

        $form = $this->createForm(new OutgoType(), $outgo);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($outgo);
            $em->flush();

            $routeOptions = array(
                'id' => $outgo->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_outgo', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Outgo from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\OutgoType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Outgo is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Outgo id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Outgo not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $outgo = $em->getRepository('AppBundle:Outgo')->find($id);

        if (!$outgo) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new OutgoType(), $outgo);
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
     * Delete a Outgo for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\OutgoType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Outgo is not found"
     *   }
     * )
     *
     * @param int $id the Outgo id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Outgo not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $outgo = $em->getRepository('AppBundle:Outgo')->find($id);

        if (!$outgo) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($outgo);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}