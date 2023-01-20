<?php


namespace App\Form;



use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ConsultationForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('patient', EntityType::class,
                ['class'=>'App\Entity\Patient',
                    'choice_label'=>'name',
                    'multiple'=>false,
                    'expanded'=>false])

            ->add('doctor', EntityType::class,
                ['class'=>'App\Entity\User',
                    'choice_label'=>'name',
                    'multiple'=>false,
                    'expanded'=>false])
            ->add('dateConsultation', TextType::class)
            ->add('description', TextType::class)
        ;
    }

}

