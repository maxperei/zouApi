<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\ItemCategory;
use AppBundle\Form\ItemCategoryType;

class ItemCategoryController extends FOSRestController
{
    /**
     * Get an Item Category for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\ItemCategory",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Item Category is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:ItemCategory:show.html.twig",
     *  templateVar="itemCategory"
     * )
     *
     * @param int $id the Item Category id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Item Category not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $itemCategory = $em->getRepository('AppBundle:ItemCategory')->find($id);

        if (!$itemCategory) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $itemCategory;
    }

    /**
     * Get all Item Categories.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:ItemCategory:index.html.twig",
     *  templateVar="itemCategories"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $itemCategories = $em->getRepository('AppBundle:ItemCategory')->findAll();

        return $itemCategories;
    }

    /**
     * Create a new Item Category from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ItemCategoryType",
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
        $itemCategory = new ItemCategory();

        $form = $this->createForm(new ItemCategoryType(), $itemCategory);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($itemCategory);
            $em->flush();

            $routeOptions = array(
                'id' => $itemCategory->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_itemcategory', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Item Category from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ItemCategoryType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the ItemCategory is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Item Category id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Item Category not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $itemCategory = $em->getRepository('AppBundle:ItemCategory')->find($id);

        if (!$itemCategory) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new ItemCategoryType(), $itemCategory);
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
     * Delete a Item Category for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ItemCategoryType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Item Category is not found"
     *   }
     * )
     *
     * @param int $id the Item Category id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Item Category not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $itemCategory = $em->getRepository('AppBundle:ItemCategory')->find($id);

        if (!$itemCategory) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($itemCategory);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}