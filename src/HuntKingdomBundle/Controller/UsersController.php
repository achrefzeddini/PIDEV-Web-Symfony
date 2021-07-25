<?php

namespace HuntKingdomBundle\Controller;

use ApiBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class UsersController extends Controller
{
    public function createAction(Request $request)
    {
        $utilisateur = new User();
        $utilisateur->setFirstName($request->get('firstName'));
        $utilisateur->setLastName($request->get('lastName'));
        $utilisateur->setPhone($request->get('phone'));
        $utilisateur->setEmail($request->get('email'));
        $utilisateur->setUsername($request->get('username'));
        $utilisateur->setPlainPassword($request->get('plainPassword'));
        $utilisateur->setEnabled(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($utilisateur);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($utilisateur);
        return new JsonResponse($formatted);
    }

    //public function loginAction(Request $request) {
      //  $user = $this->get('fos_user.user_manager')->findUserByUsername($request->query->get('username'));
       // if ($user && $this->get('security.password_encoder')->isPasswordValid($user, $request->query->get('password'))) {
    //    $objectNormalizer = new ObjectNormalizer();
    //    $objectNormalizer->setCircularReferenceHandler(function ($object) {
    //        return $object->getId();
    //    });
    //    $serializer = new Serializer([new DateTimeNormalizer(), $objectNormalizer]);
    //    $res=array($user);
    //    return new JsonResponse($serializer->normalize($user));
    //    }
    //   return new Response(null, Response::HTTP_UNAUTHORIZED);
    //    }

     public function loginAction($username, $password)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');

        $data = [
            'type' => 'validation error',
            'title' => 'There was a validation error',
            'errors' => 'username or password invalide'
        ];
        $response = new JsonResponse($data, 400);

        $utilisateur = $user_manager->findUserByUsername($username);
        if (!$utilisateur)
            return $response;

        $encoder = $factory->getEncoder($utilisateur);

        $bool = ($encoder->isPasswordValid($utilisateur->getPassword(), $password, $utilisateur->getSalt())) ? "true" : "false";
        if ($bool == "true") {
            $role = $utilisateur->getRoles();

            $data = array('type' => 'Login succeed',
                'id' => $utilisateur->getId(),

                'username' => $utilisateur->getUsername(),
                'email' => $utilisateur->getEmail(),

            );

            $response = new JsonResponse($data, 200);
            return $response;

        } else {
            return $response;

        }

    }

    public function showAction()
    {
        $users = $this->getDoctrine()->getManager()
            ->getRepository('ApiBundle:User')
            ->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($users) {
            return $users->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize($users);
        return new JsonResponse($formatted);
    }

    public function findAction($id)
    {
        $users = $this->getDoctrine()->getManager()
            ->getRepository('ApiBundle:User')
            ->find($id);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($users) {
            return $users->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize($users);
        return new JsonResponse($formatted);
    }

}