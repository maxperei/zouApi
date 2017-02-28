<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\OutgoCategory;
use AppBundle\Form\OutgoCategoryType;

class OutgoCategoryController extends FOSRestController
{
    /**
     * Get an Outgo Category for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\OutgoCategory",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Outgo Category is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:OutgoCategory:show.html.twig",
     *  templateVar="outgoCategory"
     * )
     *
     * @param int $id the Outgo Category id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Outgo Category not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $outgoCategory = $em->getRepository('AppBundle:OutgoCategory')->find($id);

        if (!$outgoCategory) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $outgoCategory;
    }

    /**
     * Get all Outgo Categories.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:OutgoCategory:index.html.twig",
     *  templateVar="outgoCategories"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $outgoCategories = $em->getRepository('AppBundle:OutgoCategory')->findAll();

        return $outgoCategories;
    }

    /**
     * Create a new Outgo Category from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\OutgoCategoryType",
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
        $outgoCategory = new OutgoCategory();

        $form = $this->createForm(new OutgoCategoryType(), $outgoCategory);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($outgoCategory);
            $em->flush();

            $routeOptions = array(
                'id' => $outgoCategory->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_outgocategory', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Outgo Category from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\OutgoCategoryType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the OutgoCategory is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Outgo Category id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Outgo Category not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $outgoCategory = $em->getRepository('AppBundle:OutgoCategory')->find($id);

        if (!$outgoCategory) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new OutgoCategoryType(), $outgoCategory);
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
     * Delete a Outgo Category for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\OutgoCategoryType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Outgo Category is not found"
     *   }
     * )
     *
     * @param int $id the Outgo Category id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Outgo Category not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $outgoCategory = $em->getRepository('AppBundle:OutgoCategory')->find($id);

        if (!$outgoCategory) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($outgoCategory);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}