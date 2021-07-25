<?php

namespace HuntKingdomBundle\Controller;


use HuntKingdomBundle\Entity\Animal;
use HuntKingdomBundle\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiSeasonController extends Controller
{
    public function allAction()
    {
        $seasons = $this->getDoctrine()->getManager()
            ->getRepository('HuntKingdomBundle:Season')
            ->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($seasons) {
            return $seasons->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($seasons);
        return new JsonResponse($formatted);
    }
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $season = new Season();


        $season->setNom($request->get('nom'));
        try {
            $date = new \DateTime($request->get('start'));
            $season->setStart($date);

            $date1 = new \DateTime($request->get('finish'));
            $season->setFinish($date1);
        } catch (\Exception $e) {

        }

        $season->setDescription($request->get('description'));
        try {
        $em->persist($season);
        $em->flush();
        } catch (\Exception $e) {

        }
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($seasons) {
            return $seasons->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($season);
        return new JsonResponse($formatted);
    }

    public function updateApiAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $season = $em->getRepository('HuntKingdomBundle:Season')->find($id);

        $season->setNom($request->get('nom'));
        try {
            $date = new \DateTime($request->get('start'));
            $season->setStart($date);

            $date1 = new \DateTime($request->get('finish'));
            $season->setFinish($date1);
        } catch (\Exception $e) {

        }
        $season->setDescription($request->get('description'));


        $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($seasons) {
            return $seasons->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($season);
        return new JsonResponse($formatted);


    }

}
