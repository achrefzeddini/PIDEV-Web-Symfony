<?php

namespace GestionEventBundle\Controller;

use GestionEventBundle\Entity\Event;
use GestionEventBundle\Entity\Reservation;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{

    public function eventsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('GestionEventBundle:Event')->findAll();

        return $this->render("@GestionEvent/front/events.html.twig", array(
            'events' => $events,
        ));
    }


    public function reserverAction (Request $request,$idEvent){

        $r = new Reservation();
        $form = $this->createFormBuilder($r)
            ->add('nomReservation', TextType::class)
            ->add('datereservation', TextType::class)
            ->add('quantite', NumberType::class)
            ->add('type', ChoiceType::class, ["choices"=>["Type 1"=> "Type 1","Type 2"=> "Type 2","Type 3"=> "Type 3"]])
            ->add('seat', ChoiceType::class, ["choices"=>["Seat 1"=> "Seat 1","Seat 2"=> "Seat 2","Seat 3"=> "Seat 3"]])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $r = $form->getData();
            $r->setIduser(4);
            $r->setTotal(75);
            $r->setPayer(1);
            $e = $em->getRepository(Event::class)->find($idEvent);
            $r->setIdevent($idEvent);
            

            $em->persist($r);
            $em->flush();

            return $this->redirectToRoute('front_events');

        }
        return $this->render("@GestionEvent/front/reservation.html.twig", array(
            'form'=>$form->createView()
        ));
    }


    public function myEventsAction(){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("select e from GestionEventBundle:Reservation r inner join GestionEventBundle:Event e with r.idevent = e.idevent  where r.iduser = ?1");
        $query->setParameter(1,$this->container->get('security.token_storage')->getToken()->getUser());
        $evts = $query->getResult();

        return $this->render("@GestionEvent/front/evts.html.twig", array(
            'evts'=>$evts
        ));
    }


    public function pdfAction(){

        $query =$this->getDoctrine()->getManager()->createQuery("select e from GestionEventBundle:Reservation r inner join GestionEventBundle:Event e with r.idevent = e.idevent  where r.iduser = ?1");
        $query->setParameter(1,$this->container->get('security.token_storage')->getToken()->getUser());
        $evts = $query->getResult();

        $html = $this->renderView("@GestionEvent/front/pdf.html.twig", array(
            'evts'=>$evts
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }
}
