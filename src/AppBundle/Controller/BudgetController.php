<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Budget;
use AppBundle\Form\BudgetType;

class BudgetController extends FOSRestController
{
    /**
     * Get an Budget for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Budget",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Budget is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Budget:show.html.twig",
     *  templateVar="budget"
     * )
     *
     * @param int $id the Budget id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Budget not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $budget = $em->getRepository('AppBundle:Budget')->find($id);

        if (!$budget) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $budget;
    }

    /**
     * Get all Budgets.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Budget:index.html.twig",
     *  templateVar="budgets"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $budgets = $em->getRepository('AppBundle:Budget')->findAll();

        return $budgets;
    }

    /**
     * Create a new Budget from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\BudgetType",
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
        $budget = new Budget();

        $form = $this->createForm(new BudgetType(), $budget);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($budget);
            $em->flush();

            $routeOptions = array(
                'id' => $budget->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_budget', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Budget from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\BudgetType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Budget is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Budget id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Budget not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $budget = $em->getRepository('AppBundle:Budget')->find($id);

        if (!$budget) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new BudgetType(), $budget);
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
     * Delete a Budget for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\BudgetType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Budget is not found"
     *   }
     * )
     *
     * @param int $id the Budget id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Budget not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $budget = $em->getRepository('AppBundle:Budget')->find($id);

        if (!$budget) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($budget);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}