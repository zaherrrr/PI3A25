<?php

namespace App\Form;

use App\Entity\PostulerFreelance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostulerFreelanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_postulation_fr')
            ->add('etat_postulation_fr')
            ->add('users')
            ->add('postulerFreelance')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostulerFreelance::class,
        ]);
    }
}
