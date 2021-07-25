<?php

namespace HuntKingdomBundle\Form;

use Doctrine\ORM\Mapping\Entity;
use HuntKingdomBundle\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class AnimalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

         $builder->add('idA')
                 ->add('race')
                 ->add('saison',EntityType::class, [

                 'class' => Season::class,

                 // season the season.nom property as the visible option string
                 'choice_label' => 'nom',
             ])
                /* ->add('saison',ChoiceType::class,array(
                     'choices'=>array(
                         'fall'=>'fall',
                         'summer'=>'summer',
                         'winter'=>'winter',
                         'spring'=>'spring',
                         'all'=>'all'
                     )
                 ))*/
                 ->add('place')
                 ->add('image')
                 ->add('hunted');


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HuntKingdomBundle\Entity\Animal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'huntkingdombundle_animal';
    }


}
