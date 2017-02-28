<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;

class ProjectController extends FOSRestController
{
    /**
     * Get an Project for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Project",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Project is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Project:show.html.twig",
     *  templateVar="project"
     * )
     *
     * @param int $id the Project id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Project not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('AppBundle:Project')->find($id);

        if (!$project) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $project;
    }

    /**
     * Get all Projects.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Project:index.html.twig",
     *  templateVar="projects"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('AppBundle:Project')->findAll();

        return $projects;
    }

    /**
     * Create a new Project from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProjectType",
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
        $project = new Project();

        $form = $this->createForm(new ProjectType(), $project);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            $routeOptions = array(
                'id' => $project->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_project', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Project from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProjectType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Project is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Project id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Project not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('AppBundle:Project')->find($id);

        if (!$project) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new ProjectType(), $project);
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
     * Delete a Project for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProjectType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Project is not found"
     *   }
     * )
     *
     * @param int $id the Project id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Project not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('AppBundle:Project')->find($id);

        if (!$project) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($project);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}