<?php

namespace ImenBundle\Controller;

use ImenBundle\Entity\Annonce;
use ImenBundle\Entity\Commentaire;
use ImenBundle\Entity\User;
use ImenBundle\Form\CommentaireType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentaireController extends Controller{

    public function afficherCommentairesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("ImenBundle:Commentaire")->findAll();
        return $this->render("@Imen/Commentaire/AfficherCommentaires.html.twig", array('commentaire' => $commentaire));
    }


    public function modifierCommentaireAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("ImenBundle:Commentaire")->find($id);
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('info', 'Updated!');
            return $this->redirectToRoute('imen_afficherCommentaires');
        }
        return $this->render("@Imen/Commentaire/ModifierCommentaire.html.twig", array("form" => $form->createView()));
    }

    public function supprimerCommentaireAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("ImenBundle:Commentaire")->find($id);
        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('imen_afficherCommentaires');
    }




    /*   USER */
    public function ajouterCommentaireUserAction(Request $request,Annonce $ida)
    {
        $user = $this->getUser();
        $commentaire = new Commentaire();
        $commentaire->setDateCommentaire(new \DateTime('now'));
        $commentaire->setAnnonce($ida);
        $commentaire->setUser($user);

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //$user = $em->getRepository(User::class)->find(1);
            //$commentaire->setUser($user);



            $em->persist($commentaire);
            $em->flush();
        }
        return $this->render('@Imen/Commentaire/AjouterCommentaire.html.twig', array('form' => $form->createView()));

    }

    public function supprimerCommentaireUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("ImenBundle:Commentaire")->find($id);
        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('imen_afficherAnnonce');
    }


    public function modifierCommentaireUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("ImenBundle:Commentaire")->find($id);
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('info', 'Updated!');
            //return $this->redirectToRoute('imen_afficherCommentaires');
        }
        return $this->render("@Imen/Commentaire/ModifierCommentaireUser.html.twig", array("form" => $form->createView()));
    }




}
