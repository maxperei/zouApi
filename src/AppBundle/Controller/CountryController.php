<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Country;
use AppBundle\Form\CountryType;

class CountryController extends FOSRestController
{
    /**
     * Get an Country for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\Country",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Country is not found"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Country:show.html.twig",
     *  templateVar="country"
     * )
     *
     * @param int $id the Country id
     *
     * @return array
     *
     * @throws NotFoundHttpException when Country not exist
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $country = $em->getRepository('AppBundle:Country')->find($id);

        if (!$country) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $country;
    }

    /**
     * Get all Countries.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View(
     *  template = "AppBundle:Country:index.html.twig",
     *  templateVar="countries"
     * )
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function allAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $countries = $em->getRepository('AppBundle:Country')->findAll();

        return $countries;
    }

    /**
     * Create a new Country from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\CountryType",
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
        $country = new Country();

        $form = $this->createForm(new CountryType(), $country);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();

            $routeOptions = array(
                'id' => $country->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('get_country', $routeOptions, Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * Update an existing Country from the submitted data for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\CountryType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     404 = "Returned when the Country is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the Country id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when Country not exist
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $country = $em->getRepository('AppBundle:Country')->find($id);

        if (!$country) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $form = $this->createForm(new CountryType(), $country);
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
     * Delete a Country for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\CountryType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Country is not found"
     *   }
     * )
     *
     * @param int $id the Country id
     *
     * @return View
     *
     * @throws NotFoundHttpException when Country not exist
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $country = $em->getRepository('AppBundle:Country')->find($id);

        if (!$country) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $em->remove($country);
        $em->flush();

        $statusCode = Response::HTTP_NO_CONTENT;
        $response = new Response();
        $response->setStatusCode($statusCode);

        return $response;
    }
}