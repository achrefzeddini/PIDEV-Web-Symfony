<?php

namespace ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use ProductBundle\Entity\Product;
use ProductBundle\Entity\Promotion;

class DefaultController extends Controller
{


  /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {


        return $this->render('@Product/Default/user.html.twig');
    }

    /**
     * @Route("/admin", name="homeadmin")
     */
    public function indexadminAction()
    {


      $products = $this->getDoctrine()
      ->getRepository('ProductBundle:Product')
      ->findAll();

      $n=0;

      foreach($products as $prod) { 
        
        $n=$n+1; 
      }
      return $this->render('@Product/Default/admin.html.twig',
      array('number' => $n)
    );
    }
  // product crud

    
    /**
     * @Route("/create-product/{id}")
     */
public function createAction(Request $request  , $id) {

    $product = new Product();


   
   

    $form = $this->createFormBuilder($product)
      ->add('name', TextType::class)
      ->add('price', NumberType::class)
      ->add('description', TextareaType::class)
      ->add('photo', TextType::class,
      array('required' => false, 'attr' => array('placeholder' => 'www.example.com')))
      ->add('save', SubmitType::class, array('label' => 'New product'))
      ->getForm();
  
    $form->handleRequest($request);
  

    $user = $this->getDoctrine()
    ->getRepository('ProductBundle:User')
    ->find($id);
    $product->setUser($user);


    if ($form->isSubmitted()&& $form->isValid()) {
  
      $product = $form->getData();
  
      $em = $this->getDoctrine()->getManager();
      $em->persist($product);
      $em->flush();
  
      return $this->redirect('/show-my-products/1');
  
    }
  
    return $this->render(
      '@Product/product/create.html.twig',
      array('form' => $form->createView())
      
      );
  
  }


  /**
     * @Route("/create-ad")
     */
public function createadminAction(Request $request) {

  $product = new Product();

 

  $form = $this->createFormBuilder($product)
    ->add('name', TextType::class)
    ->add('price', NumberType::class)
    ->add('description', TextareaType::class)
    ->add('photo', TextType::class,
    array('required' => false, 'attr' => array('placeholder' => 'www.example.com')))
    ->add('save', SubmitType::class, array('label' => 'New product'))
    ->getForm();

  $form->handleRequest($request);

  if ($form->isSubmitted()) {

    $product = $form->getData();

    $em = $this->getDoctrine()->getManager();
    $em->persist($product);
    $em->flush();

    return $this->redirect('/show-products-ad');

  }
  $products = $this->getDoctrine()
  ->getRepository('ProductBundle:Product')
  ->findAll();

  $n=0;

  foreach($products as $prod) { 
    
    $n=$n+1; 
  }
  return $this->render(
    '@Product/product/admincreate.html.twig',
    array('form' => $form->createView(), 'number' => $n)
    );

}



  /**
* @Route("/view-product/{id}")
*/   
public function viewAction($id) {

  $product = $this->getDoctrine()
    ->getRepository('ProductBundle:Product')
    ->find($id);

  if (!$product) {
    throw $this->createNotFoundException(
    'There are no product with the following id: ' . $id
    );
  }

  return $this->render(
    '@Product/product/view.html.twig',
    array('product' => $product)
    );

}



/**
* @Route("/show-products")
*/  
public function showAction() {

  $products = $this->getDoctrine()
    ->getRepository('ProductBundle:Product')
    ->findAll();

  return $this->render(
    '@Product/product/show.html.twig',
    array('products' => $products)
    );

}
/**
* @Route("/show-my-products/{idUser}")
*/  
public function showmineAction($idUser) {

  $products = $this->getDoctrine()
    ->getRepository('ProductBundle:Product')
    ->findByUser($idUser);

  return $this->render(
    '@Product/product/myshop.html.twig',
    array('products' => $products)
    );

}

/**
* @Route("/show-products-ad")
*/  
public function showadminAction() {

  $products = $this->getDoctrine()
      ->getRepository('ProductBundle:Product')
      ->findAll();

      
      $nb1=0;
      $nb2=0;

      foreach($products as $prod) {
        $promotion = $prod->getPromotion();

        if( $promotion!=NULL) 
        { 
             $nb1=$nb1+1; 

        }
        else 
        {
            $nb2=$nb2+1;
        }

      }

      $pieChart = new PieChart();
      $pieChart->getData()->setArrayToDataTable(
        [['Products', 'status'],
         ['on promotion',     $nb1],
         ['not on promotion',      $nb2]
         
        ]
    );
 $pieChart->getOptions()->setTitle('Product Status');
 $pieChart->getOptions()->setHeight(300);
 $pieChart->getOptions()->setWidth(500);
 $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
 $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
 $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
 $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
 $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


 $products = $this->getDoctrine()
 ->getRepository('ProductBundle:Product')
 ->findAll();

 $n=0;

 foreach($products as $prod) { 
   
   $n=$n+1; 
 }
      

  return $this->render(
    '@Product/product/adminshow.html.twig',
    array('products' => $products , 'piechart' => $pieChart , 'number' => $n)
    );

}
//just to add something

/**
* @Route("/delete-product/{id}")
*/ 
public function deleteAction($id) {

  $em = $this->getDoctrine()->getManager();
  $product = $em->getRepository('ProductBundle:Product')->find($id);


  
  if (!$product) {
    throw $this->createNotFoundException( 
    'There are no products with the following id: ' . $id
    );
  }

  $em->remove($product);
  $em->flush();

  return $this->redirect('/show-my-products/1');

}
/**
* @Route("/delete-ad/{id}")
*/ 
public function deleteadminAction($id) {

  $em = $this->getDoctrine()->getManager();
  $product = $em->getRepository('ProductBundle:Product')->find($id);

  if (!$product) {
    throw $this->createNotFoundException(
    'There are no products with the following id: ' . $id
    );
  }

  $em->remove($product);
  $em->flush();

  return $this->redirect('/show-products-ad');

}


/**
* @Route("/update-product/{id}")
*/  
public function updateAction(Request $request, $id) {


  $promotions = $this->getDoctrine()
  ->getRepository('ProductBundle:Promotion')
  ->findAll();

  $em = $this->getDoctrine()->getManager();
  $product = $em->getRepository('ProductBundle:Product')->find($id);

  if (!$product) {
    throw $this->createNotFoundException(
    'There are no product with the following id: ' . $id
    );
  }

  $form = $this->createFormBuilder($product)
      ->add('name', TextType::class)
      ->add('price', NumberType::class)
      ->add('description', TextareaType::class)
      ->add('photo', TextType::class,
      array('required' => false, 'attr' => array('placeholder' => 'www.example.com')))
      ->add('save', SubmitType::class, array('label' => 'Update'))
      ->getForm();

  $form->handleRequest($request);

  if ($form->isSubmitted()) {

    $product = $form->getData();
    $em->flush();

    return $this->redirect('/show-my-products/1');

  }

  return $this->render(
    '@Product/product/update.html.twig',
    array('form' => $form->createView() , 'promotions' => $promotions , 'product' => $product)
    );

}

 /**
* @Route("/apply-promotion/{id1}/{id2}")
*/   
public function applyAction($id1 , $id2) {

  $em = $this->getDoctrine()->getManager();
 

  $product = $this->getDoctrine()
    ->getRepository('ProductBundle:Product')
    ->find($id1);

    $promotion = $this->getDoctrine()
    ->getRepository('ProductBundle:Promotion')
    ->find($id2);

  if (!$product) {
    throw $this->createNotFoundException(
    'There are no product with the following id: ' . $id1
    );
  }

  $product->setPromotion($promotion);
  $new_price = $product->getPrice() - (( $product->getPrice()*$promotion->getPercentage() ) /100);
  $product->setPrice($new_price);


  $em = $this->getDoctrine()->getManager();
  $em->persist($product);
  $em->flush();


  

  return $this->redirect('/update-product/' . $id1); 

}


// promotion crud

   
    /**
     * @Route("/create-promotion")
     */
public function createproAction(Request $request) {

    $promotion = new Promotion();
    $form = $this->createFormBuilder($promotion)
      ->add('name', TextType::class)
      ->add('percentage', NumberType::class)
      ->add('description', TextareaType::class)
      ->add('nbdays', NumberType::class)
      ->add('save', SubmitType::class, array('label' => 'New promotion'))
      ->getForm();
  
    $form->handleRequest($request);
  
    if ($form->isSubmitted()) {
  
      $promotion = $form->getData();
  
      $em = $this->getDoctrine()->getManager();
      $em->persist($promotion);
      $em->flush();
  
      return $this->redirect('/show-promotions' );
  
    }
  
    return $this->render(
      '@Product/promotion/create.html.twig',
      array('form' => $form->createView())
      );
  
  }



  /**
* @Route("/view-promotion/{id}")
*/   
public function viewproAction($id) {

  $promotion = $this->getDoctrine()
    ->getRepository('ProductBundle:Promotion')
    ->find($id);

  if (!$promotion) {
    throw $this->createNotFoundException(
    'There are no promotion with the following id: ' . $id
    );
  }

  return $this->render(
    '@Product/promotion/view.html.twig',
    array('promotion' => $promotion)
    );

}



/**
* @Route("/show-promotions")
*/  
public function showproAction() {

  $promotions = $this->getDoctrine()
    ->getRepository('ProductBundle:Promotion')
    ->findAll();

  return $this->render(
    '@Product/promotion/show.html.twig',
    array('promotions' => $promotions)
    );

}

/**
* @Route("/delete-promotion/{id}")
*/ 
public function deleteproAction($id) {

  $em = $this->getDoctrine()->getManager();
  $promotion = $em->getRepository('ProductBundle:Promotion')->find($id);

  if (!$promotion) {
    throw $this->createNotFoundException(
    'There are no promotion with the following id: ' . $id
    );
  }

  $em->remove($promotion);
  $em->flush();

  return $this->redirect('/show-promotions');

}


/**
* @Route("/update-promotion/{id}")
*/  
public function updateproAction(Request $request, $id) {

  $em = $this->getDoctrine()->getManager();
  $promotion = $em->getRepository('ProductBundle:Promotion')->find($id);

  if (!$promotion) {
    throw $this->createNotFoundException(
    'There are no promotion with the following id: ' . $id
    );
  }

  $form = $this->createFormBuilder($promotion)
  ->add('name', TextType::class)
  ->add('percentage', NumberType::class)
  ->add('description', TextareaType::class)
  ->add('nbdays', NumberType::class)
  ->add('save', SubmitType::class, array('label' => 'update'))
  ->getForm();

  $form->handleRequest($request);

  if ($form->isSubmitted()) {

    $promotion = $form->getData();
    $em->flush();

    return $this->redirect('/view-promotion/' . $id);

  }

  return $this->render(
    '@Product/promotion/create.html.twig',
    array('form' => $form->createView())
    );

}

}
