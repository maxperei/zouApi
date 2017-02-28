<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;

class PostController extends FOSRestController
{
    /**
     * Get an Post for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Post",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Post is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Post:show.html.twig",
     *  templateVar="post"
     * )
     *
     * @param int $id the Post id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Post not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($id);

        if (!$post) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $post;
    }

    /**
     * Get all Posts.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Post:index.html.twig",
     *  templateVar="posts"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')->findAll();

        return $posts;
    }

    /**
     * Create a new Post from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\PostType",
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
        $post = new Post();

        $form = $this->createForm(new PostType(), $post);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $routeOptions = array(
                'id' => $post->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_post', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Post from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\PostType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Post is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Post id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Post not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($id);

        if (!$post) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new PostType(), $post);
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
     * Delete a Post for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\PostType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Post is not found"
     *   }
     * )
     *
     * @param int $id the Post id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Post not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($id);

        if (!$post) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($post);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}