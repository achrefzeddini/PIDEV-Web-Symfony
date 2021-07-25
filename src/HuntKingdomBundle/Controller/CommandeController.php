<?php

namespace HuntKingdomBundle\Controller;

use HuntKingdomBundle\Entity\Animal;
use HuntKingdomBundle\Entity\Commande;
use HuntKingdomBundle\Form\AnimalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class CommandeController extends Controller
{
    public function showCommandeAction()
    {
        $cm = new Commande();
        $em= $this->getDoctrine()->getManager();
        $state = $cm->getState();
        $commande =$em->getRepository('HuntKingdomBundle:Commande')->findByState($state=1);
        return $this->render('@HuntKingdom/Commande/ShowCommande.html.twig',array(
            'commande'=> $commande));
    }

    public function showCommandeUserAction()
    {   $username= $this->get('security.token_storage')->getToken()->getUser();
        $em= $this->getDoctrine()->getManager();
        $commande =$em->getRepository('HuntKingdomBundle:Commande')->findBy(array('state'=>0));
        return $this->render('@HuntKingdom/Commande/ShowCommandeUser.html.twig',array(
            'commande'=> $commande));
    }

    public function orderCommandeUserAction($id , Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $commande = $em->getRepository('HuntKingdomBundle:Commande')->find($id);
        $commande->setState(1);
        $em->persist($commande);
        $em->flush();
       
        return $this->redirectToRoute("hunt_kingdom_showCommandeUser");
    }
    public function deleteCommandeUserAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $commande=$em->getRepository(Commande::class)->find($id);
        $em->remove($commande);
        $em->flush();


    }

}
