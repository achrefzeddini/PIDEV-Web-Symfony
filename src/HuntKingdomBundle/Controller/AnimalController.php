<?php

namespace HuntKingdomBundle\Controller;

use HuntKingdomBundle\Entity\Animal;
use HuntKingdomBundle\Entity\Season;
use HuntKingdomBundle\Form\AnimalType;
use HuntKingdomBundle\HuntKingdomBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

class AnimalController extends Controller
{
    public function ajoutAnimalAction(Request $request)
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class,$animal);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $saison = $animal->getSaison();
            $em = $this->getDoctrine()->getManager();
            $array_saison = $em->getRepository(Season::class)->findByNom($saison);
            $animal->setSeason($saison);

                $em->persist($animal);
                $em->flush();
                $this->addFlash('info', 'Created Successfully !');
                return $this->redirectToRoute('hunt_kingdom_showAnimal');



        }

        return $this->render("@HuntKingdom/Animal/ajoutAnimal.html.Twig",array("form"=>$form->createView()));
    }
    public function updateAnimalAction($id , Request $request){

        $em = $this->getDoctrine()->getManager();
        $animal = $em->getRepository(Animal::class)->find($id);
        $form = $this->createForm(AnimalType::class, $animal);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $saison = $animal->getSaison();
            $em=$this->getDoctrine()->getManager();
            $animal->setSeason($saison);
            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute("hunt_kingdom_showAnimal");
        }
        return $this->render('@HuntKingdom/Animal/updateAnimal.html.twig',array('form'=>$form->createView()));

    }
    public function deleteAnimalAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $animal=$em->getRepository(Animal::class)->find($id);
        $em->remove($animal);
        $em->flush();
        return $this->redirectToRoute("hunt_kingdom_showAnimal");

    }



    public function showAnimalAction()
    {
        $em= $this->getDoctrine()->getManager();
        $animal =$em->getRepository('HuntKingdomBundle:Animal')->findAll();
        $pieChart = new PieChart();
        $em= $this->getDoctrine();

        $animal1 = $em->getRepository(Animal::class)->find(1);
        $c1=$animal1->getHunted();
        $animal2 = $em->getRepository(Animal::class)->find(2);
        $c2=$animal2->getHunted();
        $animal3= $em->getRepository(Animal::class)->find(3);
        $c3=$animal3->getHunted();


        $total=$c1+$c2+$c3;

        $total1=$c1;
        $total2=$c2;
        $total3=$c3;

        $data= array();
        $stat=['Les Profils', '%'];
        $nb=0;
        array_push($data,$stat);

        $stat=array();
        $nb1=($total1 *100)/$total;
        array_push($stat,'Fish',($total1));
        $stat=['Fish',$nb1];
        array_push($data,$stat);

        $stat=array();
        $nb2=($total2 *100)/$total;
        array_push($stat,'deer',($total2));
        $stat=['deer',$nb2];
        array_push($data,$stat);

        $stat=array();
        $nb3=($total3 *100)/$total;
        array_push($stat,'op',($total3));
        $stat=['op',$nb3];
        array_push($data,$stat);


        $pieChart->getData()->setArrayToDataTable(
            $data
        );


        $pieChart->getOptions()->setTitle('Hunting Statistics');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@HuntKingdom/Animal/showAnimal.html.twig',array(
            'animal'=> $animal,'piechart' => $pieChart));
    }
    public function frontAnimalAction()
    {
        $em= $this->getDoctrine()->getManager();
        $animal =$em->getRepository('HuntKingdomBundle:Animal')->findAll();
        return $this->render('@HuntKingdom/Animal/frontAnimal.html.twig',array(
            'animal'=> $animal));
    }
    public function AffAdminAction(Request $request)
    {

    }

}
