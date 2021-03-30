<?php

namespace App\Form;

use App\Entity\CategoryFreelance;
use App\Entity\OffreFreelance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('categorieFreelance',EntityType::class,[
                'class'=>CategoryFreelance::class,
                'choice_label'=>'nom_cat_fr',


            ])->add('Enregistrer',SubmitType::class,[
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OffreFreelance::class,
        ]);
    }
}
