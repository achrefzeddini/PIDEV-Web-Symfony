<?php

namespace GestionEventBundle\Controller;

use AppBundle\Entity\User;
use GestionEventBundle\Entity\Event;
use GestionEventBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionEventBundle:Default:index.html.twig');
    }



    public function wsGetEventsAction(){
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository(Event::class)->findAll();


        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($events, 'json',['attributes'=>['idevent','titre','nbrplaces','localisation','hdebut','hfin','prix','image']]);


        return new Response($jsonContent);
    }



    public function wsGetMyEventsAction(Request $request){

        $query =$this->getDoctrine()->getManager()->createQuery("select e from GestionEventBundle:Reservation r inner join GestionEventBundle:Event e with r.idevent = e.idevent  where r.iduser = ?1");
        $query->setParameter(1,$request->get('id'));
        $events = $query->getResult();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($events, 'json',['attributes'=>['idevent','titre','nbrplaces','localisation','hdebut','hfin','prix','image']]);


        return new Response($jsonContent);
    }


    public function reserverAction (Request $request){

        $r = new Reservation();

            $em = $this->getDoctrine()->getManager();
            $r->setNomreservation($request->get('nom'));
            $r->setDatereservation(\DateTime::createFromFormat("d-m-Y",$request->get('date')));
            $r->setQuantite($request->get('qte'));
            $r->setType($request->get('type'));
            $r->setSeat($request->get('seat'));
            $r->setIduser($this->getDoctrine()->getManager()->getRepository(User::class)->find($request->get('idUser')));
            $e = $em->getRepository(Event::class)->find($request->get('idEvent'));
            $r->setIdevent($e);
            $e->addReservation($r);

            $em->persist($r);
            $em->flush();

        return new Response("");
    }



}
