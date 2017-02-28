<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Item;
use AppBundle\Form\ItemType;

class ItemController extends FOSRestController
{
    /**
     * Get an Item for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Item",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Item is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Item:show.html.twig",
     *  templateVar="item"
     * )
     *
     * @param int $id the Item id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Item not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Item')->find($id);

        if (!$item) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $item;
    }

    /**
     * Get all Items.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Item:index.html.twig",
     *  templateVar="items"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('AppBundle:Item')->findAll();

        return $items;
    }

    /**
     * Create a new Item from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ItemType",
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
        $item = new Item();

        $form = $this->createForm(new ItemType(), $item);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $routeOptions = array(
                'id' => $item->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_item', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Item from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ItemType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Item is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Item id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Item not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Item')->find($id);

        if (!$item) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new ItemType(), $item);
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
     * Delete a Item for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ItemType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Item is not found"
     *   }
     * )
     *
     * @param int $id the Item id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Item not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Item')->find($id);

        if (!$item) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($item);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}