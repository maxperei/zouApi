<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\UserPref;
use AppBundle\Form\UserPrefType;

class UserPrefController extends FOSRestController
{
    /**
     * Get an User Pref for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\UserPref",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the UserPref is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:UserPref:show.html.twig",
     *  templateVar="userPref"
     * )
     *
     * @param int $id the User Pref id
     *
     * @return array
     *
     * @throws NotFoundHttpException when User Pref not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userPref = $em->getRepository('AppBundle:UserPref')->find($id);

        if (!$userPref) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $userPref;
    }

    /**
     * Get all User Prefs.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:UserPref:index.html.twig",
     *  templateVar="userPrefs"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userPrefs = $em->getRepository('AppBundle:UserPref')->findAll();

        return $userPrefs;
    }

    /**
     * Create a new User Pref from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\UserPrefType",
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
        $userPref = new UserPref();

        $form = $this->createForm(new UserPrefType(), $userPref);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($userPref);
            $em->flush();

            $routeOptions = array(
                'id' => $userPref->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_userpref', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing UserPref from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\UserPrefType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the UserPref is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the UserPref id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when UserPref not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $userPref = $em->getRepository('AppBundle:UserPref')->find($id);

        if (!$userPref) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new UserPrefType(), $userPref);
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
     * Delete a UserPref for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\UserPrefType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the UserPref is not found"
     *   }
     * )
     *
     * @param int $id the UserPref id
     *
     * @return View
     *
     * @throws NotFoundHttpException when UserPref not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userPref = $em->getRepository('AppBundle:UserPref')->find($id);

        if (!$userPref) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($userPref);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}