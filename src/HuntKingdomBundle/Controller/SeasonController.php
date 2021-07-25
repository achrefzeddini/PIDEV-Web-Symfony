<?php

namespace HuntKingdomBundle\Controller;
use HuntKingdomBundle\Entity\Animal;
use HuntKingdomBundle\Entity\Season;
use HuntKingdomBundle\Form\SeasonType;
use HuntKingdomBundle\HuntKingdomBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SeasonController extends Controller
{
    public function ajoutSeasonAction(Request $request)
    {
        $season = new Season();
        $form = $this->createForm(SeasonType::class,$season);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($season);
            $em->flush();
            $this->addFlash('info', 'Created Successfully !');
            return $this->redirectToRoute('hunt_kingdom_showSeason');

        }

        return $this->render("@HuntKingdom/Season/ajoutSeason.html.Twig",array("form"=>$form->createView()));
    }

    public function updateSeasonAction($id , Request $request){

        $em = $this->getDoctrine()->getManager();
        $season = $em->getRepository(Season::class)->find($id);
        $form = $this->createForm(SeasonType::class, $season);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($season);
            $em->flush();

            return $this->redirectToRoute("hunt_kingdom_showSeason");
        }
        return $this->render('@HuntKingdom/Season/updateSeason.html.twig',array('form'=>$form->createView()));
    }

    public function deleteSeasonAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $season=$em->getRepository(Season::class)->find($id);
        $em->remove($season);
        $em->flush();
        return $this->redirectToRoute("hunt_kingdom_showSeason");
    }
    public function showSeasonAction()
    {
        $em= $this->getDoctrine()->getManager();
        $season =$em->getRepository('HuntKingdomBundle:Season')->findAll();
        return $this->render('@HuntKingdom/Season/showSeason.html.twig',array(
            'season'=> $season));
    }
    public function frontSeasonAction()
    {
        $em= $this->getDoctrine()->getManager();
        $season =$em->getRepository('HuntKingdomBundle:Season')->findAll();
        return $this->render('@HuntKingdom/Season/frontSeason.html.twig',array(
            'season'=> $season));
    }
}
