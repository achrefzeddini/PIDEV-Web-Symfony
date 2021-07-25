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

class ApiCommandeController extends Controller
{
    public function allAction()
    { $username= $this->get('security.token_storage')->getToken()->getUser();
        $commandes = $this->getDoctrine()->getManager()
            ->getRepository('HuntKingdomBundle:Commande')
            ->findBy(array('state'=>0));
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($seasons) {
            return $seasons->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($commandes);
        return new JsonResponse($formatted);
    }
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new Task();
        $task->setName($request->get('name'));
        $task->setStatus($request->get('status'));
        $em->persist($task);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);
    }
    public function updateCommandeAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $commande = $em->getRepository('HuntKingdomBundle:Commande')->find($id);
        $commande->setState(1);
        $em->persist($commande);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($seasons) {
            return $seasons->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($commande);
        return new JsonResponse($formatted);
    }
    public function deleteCommandeAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $commande=$em->getRepository(Commande::class)->find($id);
        $em->remove($commande);
        $em->flush();


    }

}
