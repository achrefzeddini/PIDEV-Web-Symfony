<?php

namespace GestionEventBundle\Controller;

use GestionEventBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class EventController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository(Event::class)->findAll();

        return $this->render("@GestionEvent/event/index.html.twig", array(
            'events' => $events,
        ));
    }
    

    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('GestionEventBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->uploadPicture();
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('idevent' => $event->getIdevent()));
        }

        return $this->render("@GestionEvent/event/new.html.twig", array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }


    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render("@GestionEvent/event/show.html.twig", array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('GestionEventBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_edit', array('idevent' => $event->getIdevent()));
        }

        return $this->render("@GestionEvent/event/edit.html.twig", array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }


    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('idevent' => $event->getIdevent())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
