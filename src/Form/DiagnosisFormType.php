<?php

namespace App\Form;

use App\Entity\Diagnosis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiagnosisFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observation')
            ->add('treatment')
            ->add('doctor')
            ->add('patient')
            ->add('appointment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Diagnosis::class,
        ]);
    }
}
