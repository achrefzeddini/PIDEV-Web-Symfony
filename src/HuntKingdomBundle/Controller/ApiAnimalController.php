<?php

namespace HuntKingdomBundle\Controller;

use HuntKingdomBundle\Entity\Animal;
use HuntKingdomBundle\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;

class ApiAnimalController extends Controller
{
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT p.id , p.idA , p.race , p.saison , p.place , p.image, p.hunted  FROM HuntKingdomBundle:Animal p");
        $res = $query->getResult();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($animals) {
            return $animals->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);
    }
    public function newerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $animal = new Animal();



        $animal->setIdA($request->get('idA'));
        $animal->setRace($request->get('race'));
        $animal->setSaison($request->get('saison'));
        $animal->setPlace($request->get('place'));
        $animal->setImage($request->get('image'));
        $animal->setHunted($request->get('hunted'));

        $sa = $animal->getSaison();

        $season=$this->getDoctrine()->getRepository('HuntKingdomBundle:Season')->findOneBy(array('nom' => $sa));

        $animal->setSeason($season);
        $em->persist($animal);
        $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($animals) {
            return $animals->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($em);
        return new JsonResponse($formatted);
    }
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $animal = new Animal();



        $animal->setIdA($request->get('idA'));
        $animal->setRace($request->get('race'));
        $animal->setSaison($request->get('saison'));
        $animal->setPlace($request->get('place'));
        $animal->setImage($request->get('image'));
        $animal->setHunted($request->get('hunted'));

        $sa = $animal->getSaison();

        $season=$this->getDoctrine()->getRepository('HuntKingdomBundle:Season')->findOneBy(array('nom' => $sa));

        $animal->setSeason($season);
        $em->persist($animal);
        $em->flush();
       
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($animals) {
            return $animals->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($animal);
        return new JsonResponse($formatted);

    }
    public function updateApiAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idA=$request->get('idA');
        $animal = $em->getRepository(Animal::class)->findOneBy(array('idA' => $idA));
        $animal->setIdA($request->get('idA'));
        $animal->setRace($request->get('race'));
        $animal->setSaison($request->get('saison'));
        $animal->setPlace($request->get('place'));
        $animal->setImage($request->get('image'));
        $animal->setHunted($request->get('hunted'));
        $saison = $animal->getSaison();

        $season=$this->getDoctrine()->getRepository('HuntKingdomBundle:Season')->findOneBy(array('nom' => $saison));
        $animal->setSeason($season);

        $em->persist($animal);
        $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($animals) {
            return $animals->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($animal);
        return new JsonResponse($formatted);


    }

}
