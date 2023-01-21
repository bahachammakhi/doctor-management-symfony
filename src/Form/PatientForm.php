<?php


namespace App\Form;



use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PatientForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name', TextType::class)
            ->add('created_at', DateType::class)
            ->add('email', EmailType::class)
            ->add('age', TextType::class)
            ->add('phone', TextType::class)
            ->add('genre', TextType::class)
            ->add('address', TextType::class)
        ->add('doctor', EntityType::class,
        ['class'=>'App\Entity\User',
            'choice_label'=>'name',
            'multiple'=>false,
            'expanded'=>false])
        ;
    }

    public function getName(){
        return "Patient";
    }
}

