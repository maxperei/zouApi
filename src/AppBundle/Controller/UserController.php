<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;

class UserController extends FOSRestController
{
    /**
     * Get an User for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\User",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the User is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:User:show.html.twig",
     *  templateVar="user"
     * )
     *
     * @param int $id the User id
     *
     * @return array
     *
     * @throws NotFoundHttpException when User not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        if (!$user) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $user;
    }

    /**
     * Get all Users.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:User:index.html.twig",
     *  templateVar="users"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return $users;
    }

    /**
     * Get current authenticated User.
     *
     * @return array
     */
    public function identityAction(){
        $user = $this->get('security.context')->getToken()->getUser();

        return $user;
    }

    /**
     * Create a new User from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\UserType",
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
        $user = new User();

        $form = $this->createForm(new UserType('AppBundle\Entity\User'), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $routeOptions = array(
                'id' => $user->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_user', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing User from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\UserType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the User is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the User id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when User not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        if (!$user) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new UserType('AppBundle\Entity\User'), $user);
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
     * Delete a User for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\UserType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the User is not found"
     *   }
     * )
     *
     * @param int $id the User id
     *
     * @return View
     *
     * @throws NotFoundHttpException when User not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        if (!$user) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($user);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}