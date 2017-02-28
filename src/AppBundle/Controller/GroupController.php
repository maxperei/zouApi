<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Group;
use AppBundle\Form\GroupType;

class GroupController extends FOSRestController
{
    /**
     * Get an Group for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Group",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Group is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Group:show.html.twig",
     *  templateVar="group"
     * )
     *
     * @param int $id the Group id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Group not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('AppBundle:Group')->find($id);

        if (!$group) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $group;
    }

    /**
     * Get all Groups.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Group:index.html.twig",
     *  templateVar="groups"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('AppBundle:Group')->findAll();

        return $groups;
    }

    /**
     * Create a new Group from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\GroupType",
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
        $group = new Group();

        $form = $this->createForm(new GroupType(), $group);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            $routeOptions = array(
                'id' => $group->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_group', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Group from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\GroupType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Group is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Group id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Group not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('AppBundle:Group')->find($id);

        if (!$group) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new GroupType(), $group);
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
     * Delete a Group for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\GroupType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Group is not found"
     *   }
     * )
     *
     * @param int $id the Group id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Group not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('AppBundle:Group')->find($id);

        if (!$group) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($group);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}