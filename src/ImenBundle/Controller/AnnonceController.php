<?php



namespace ImenBundle\Controller;

use ImenBundle\Entity\Annonce;
use HuntKingdomBundle\Entity\User;
use ImenBundle\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnnonceController extends Controller{

    public function ajouterAnnonceAction(Request $request){

        $user = $this->getUser();
        $annonce = new Annonce();
        $annonce->setDateAnnonce(new \DateTime('now'));
        $annonce->setUser($user);

        $form = $this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            $this->addFlash('info','Announce Added!');
            return $this->redirectToRoute('imen_afficherAnnonces');
        }
        return $this->render('@Imen/Annonce/AjouterAnnonce.html.twig',array('form'=>$form->createView()));

    }

    //ADMIN
    public function afficherAnnoncesAction(){
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("ImenBundle:Annonce")->findAll();
        return $this->render("@Imen/Annonce/AfficherAnnonces.html.twig",array('annonce'=>$annonce));
    }

    public function modifierAnnonceAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("ImenBundle:Annonce")->find($id);
        $form = $this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('info','Updated!');
            return $this->redirectToRoute('imen_afficherAnnonces');
        }
        return $this->render("@Imen/Annonce/ModifierAnnonce.html.twig",array("form"=>$form->createView()));
    }

    public function supprimerAnnonceAction($id){
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("ImenBundle:Annonce")->find($id);
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute('imen_afficherAnnonces');
    }

    /* -------------------------- PARTIE USER  -------------------------- */

    public function modifierAnnonceUserAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("ImenBundle:Annonce")->find($id);
        $form = $this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('info','Updated!');
            return $this->redirectToRoute('imen_afficherMesAnnonces');
        }
        return $this->render("@Imen/Annonce/ModifierAnnonceUser.html.twig",array("form"=>$form->createView()));
    }


    public function supprimerAnnonceUserAction($id){
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("ImenBundle:Annonce")->find($id);
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute('imen_afficherMesAnnonces');
    }

    public function ajouterAnnonceUserAction(Request $request){

        $user = $this->getUser();
        $annonce = new Annonce();
        $annonce->setDateAnnonce(new \DateTime('now'));
        $annonce->setUser($user);

        $form = $this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            $this->addFlash('info','Announce Added!');
            return $this->redirectToRoute('imen_afficherAnnonce');
        }
        return $this->render('@Imen/Annonce/AjouterAnnonceUser.html.twig',array('form'=>$form->createView()));
    }



    public function afficherMesAnnoncesAction(Request $request){
        $id=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM ImenBundle:Annonce a WHERE a.user=:id ");
        $query->setParameter('id',$id);
        $annonce = $query->getResult();
        return $this->render("@Imen/Annonce/MesAnnonces.html.twig",array(
            'annonce'=>$annonce,));
    }



    /*----------------------- COMMENTAIRE ----------------------------*/

    //USER
    public function afficherAnnonceAction(Request $request){                //Afficher toutes les annonces
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("ImenBundle:Annonce")->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $annonce = $paginator->paginate($annonce,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 4));
        return $this->render("@Imen/Annonce/AfficherAnnonceUser.html.twig",array('annonce'=>$annonce));
    }

    public function commenterAnnonceAction($id){            //Afficher l'annonce désirée
        $em = $this->getDoctrine()->getManager();
        $iduser=4;
        $annonce = $em->getRepository("ImenBundle:Annonce")->findById($id);
        $user = $em->getRepository("ImenBundle:User")->findById($iduser);
        return $this->render("@Imen/Annonce/CommenterAnnonce.html.twig", array('annonce' => $annonce,'user' => $user));
    }



}
