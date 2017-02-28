<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Transaction;
use AppBundle\Form\TransactionType;

class TransactionController extends FOSRestController
{
    /**
     * Get an Transaction for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Transaction",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Transaction is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Transaction:show.html.twig",
     *  templateVar="transaction"
     * )
     *
     * @param int $id the Transaction id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Transaction not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $transaction = $em->getRepository('AppBundle:Transaction')->find($id);

        if (!$transaction) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $transaction;
    }

    /**
     * Get all Transactions.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Transaction:index.html.twig",
     *  templateVar="transactions"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $transactions = $em->getRepository('AppBundle:Transaction')->findAll();

        return $transactions;
    }

    /**
     * Create a new Transaction from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\TransactionType",
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
        $transaction = new Transaction();

        $form = $this->createForm(new TransactionType(), $transaction);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            $routeOptions = array(
                'id' => $transaction->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_transaction', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Transaction from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\TransactionType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Transaction is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Transaction id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Transaction not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $transaction = $em->getRepository('AppBundle:Transaction')->find($id);

        if (!$transaction) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new TransactionType(), $transaction);
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
     * Delete a Transaction for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\TransactionType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Transaction is not found"
     *   }
     * )
     *
     * @param int $id the Transaction id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Transaction not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $transaction = $em->getRepository('AppBundle:Transaction')->find($id);

        if (!$transaction) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($transaction);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}