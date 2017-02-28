<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Procedure;
use AppBundle\Form\ProcedureType;

class ProcedureController extends FOSRestController
{
    /**
     * Get an Procedure for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Procedure",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Procedure is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Procedure:show.html.twig",
     *  templateVar="procedure"
     * )
     *
     * @param int $id the Procedure id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Procedure not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $procedure = $em->getRepository('AppBundle:Procedure')->find($id);

        if (!$procedure) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $procedure;
    }

    /**
     * Get all Procedures.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Procedure:index.html.twig",
     *  templateVar="procedures"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $procedures = $em->getRepository('AppBundle:Procedure')->findAll();

        return $procedures;
    }

    /**
     * Create a new Procedure from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProcedureType",
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
        $procedure = new Procedure();

        $form = $this->createForm(new ProcedureType(), $procedure);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($procedure);
            $em->flush();

            $routeOptions = array(
                'id' => $procedure->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_procedure', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Procedure from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProcedureType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Procedure is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Procedure id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Procedure not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $procedure = $em->getRepository('AppBundle:Procedure')->find($id);

        if (!$procedure) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new ProcedureType(), $procedure);
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
     * Delete a Procedure for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProcedureType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Procedure is not found"
     *   }
     * )
     *
     * @param int $id the Procedure id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Procedure not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $procedure = $em->getRepository('AppBundle:Procedure')->find($id);

        if (!$procedure) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($procedure);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}