<?php

namespace GestionEventBundle\Controller;

use GestionEventBundle\Entity\Sponsor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sponsor controller.
 *
 */
class SponsorController extends Controller
{
    /**
     * Lists all sponsor entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sponsors = $em->getRepository('GestionEventBundle:Sponsor')->findAll();

        return $this->render("@GestionEvent/sponsor/index.html.twig", array(
            'sponsors' => $sponsors,
        ));
    }

    /**
     * Creates a new sponsor entity.
     *
     */
    public function newAction(Request $request)
    {
        $sponsor = new Sponsor();
        $form = $this->createForm('GestionEventBundle\Form\SponsorType', $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sponsor);
            $em->flush();

            return $this->redirectToRoute('sponsor_show', array('idsponsor' => $sponsor->getIdsponsor()));
        }

        return $this->render("@GestionEvent/sponsor/new.html.twig", array(
            'sponsor' => $sponsor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sponsor entity.
     *
     */
    public function showAction(Sponsor $sponsor)
    {
        $deleteForm = $this->createDeleteForm($sponsor);

        return $this->render("@GestionEvent/sponsor/show.html.twig", array(
            'sponsor' => $sponsor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sponsor entity.
     *
     */
    public function editAction(Request $request, Sponsor $sponsor)
    {
        $deleteForm = $this->createDeleteForm($sponsor);
        $editForm = $this->createForm('GestionEventBundle\Form\SponsorType', $sponsor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sponsor_edit', array('idsponsor' => $sponsor->getIdsponsor()));
        }

        return $this->render("@GestionEvent/sponsor/edit.html.twig", array(
            'sponsor' => $sponsor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sponsor entity.
     *
     */
    public function deleteAction(Request $request, Sponsor $sponsor)
    {
        $form = $this->createDeleteForm($sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sponsor);
            $em->flush();
        }

        return $this->redirectToRoute('sponsor_index');
    }

    /**
     * Creates a form to delete a sponsor entity.
     *
     * @param Sponsor $sponsor The sponsor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sponsor $sponsor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sponsor_delete', array('idsponsor' => $sponsor->getIdsponsor())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
