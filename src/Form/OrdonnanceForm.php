<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class OrdonnanceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('Medicament', TextType::class)
        ->add('description', TextareaType::class)
            // ->add('consultation', EntityType::class,
            //         ['class'=>'App\Entity\Consultation',
            //             'choice_label'=>'dateConsultation',
            //             'multiple'=>false,
            //             'expanded'=>false])

        ;
    }

    public function getName(){
        return "Ordonnance";
    }
}