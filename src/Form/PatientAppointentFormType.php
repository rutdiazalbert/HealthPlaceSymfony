<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PatientAppointentFormType extends AbstractType
{   
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('date')
            ->add('time')
            ->add('reason')
            ->add('doctor', EntityType::class, 
            [
                'class' => User::class,
                'choice_label'=>'specialties',
                // 'query_builder' => function (EntityRepository $repo) {
                //     $roles = '["ROLE_DOCTOR"]';
                //     return $repo->createQueryBuilder('u')
                //             ->select('u.name, u.specialities')
                //             ->where('u.roles = :roles')
                //             ->setParameter('roles', $roles);
                            
                // }
                
            ])
            ->add('submit', SubmitType::class, ['label'=>"Save appointment"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
