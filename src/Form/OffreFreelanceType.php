<?php

namespace App\Form;

use App\Entity\OffreFreelance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreFreelanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre_offre_fr')
            ->add('descriptionfr')
            ->add('entreprisefr')
            ->add('recomponse')
            ->add('date_expiration')
            ->add('etat_offre')
            ->add('categorieFreelance')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OffreFreelance::class,
        ]);
    }
}
