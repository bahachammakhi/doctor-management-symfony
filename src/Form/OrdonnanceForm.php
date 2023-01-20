<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class OrdonnanceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('Medicament', TextType::class)
            ->add('Date', DateType::class)
            ->add('patient', EntityType::class,
                ['class'=>'App\Entity\Patient',
                    'choice_label'=>'name',
                    'multiple'=>false,
                    'expanded'=>false])

        ;
    }

    public function getName(){
        return "Ordonnance";
    }
}