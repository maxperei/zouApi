<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\MediaPost;
use AppBundle\Form\MediaPostType;

class MediaPostController extends FOSRestController
{
    /**
     * Get an Media Post for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\MediaPost",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Media Post is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:MediaPost:show.html.twig",
     *  templateVar="mediaPost"
     * )
     *
     * @param int $id the MediaPost id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Media Post not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaPost = $em->getRepository('AppBundle:MediaPost')->find($id);

        if (!$mediaPost) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $mediaPost;
    }

    /**
     * Get all Media Posts.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:MediaPost:index.html.twig",
     *  templateVar="mediaPosts"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaPosts = $em->getRepository('AppBundle:MediaPost')->findAll();

        return $mediaPosts;
    }

    /**
     * Create a new Media Post from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\MediaPostType",
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
        $mediaPost = new MediaPost();

        $form = $this->createForm(new MediaPostType(), $mediaPost);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($mediaPost);
            $em->flush();

            $routeOptions = array(
                'id' => $mediaPost->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_mediapost', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Media Post from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\MediaPostType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Media Post is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the MediaPost id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when MediaPost not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaPost = $em->getRepository('AppBundle:MediaPost')->find($id);

        if (!$mediaPost) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new MediaPostType(), $mediaPost);
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
     * Delete a Media Post for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\MediaPostType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Media Post is not found"
     *   }
     * )
     *
     * @param int $id the MediaPost id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Media Post not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaPost = $em->getRepository('AppBundle:MediaPost')->find($id);

        if (!$mediaPost) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($mediaPost);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}