<?php

namespace App\Form;

use App\Entity\CategorieQuestionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieQuestionnaire1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_cat_qst')
            ->add('description_cat_qst')
            ->add('Enregistrer',SubmitType::class,[
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategorieQuestionnaire::class,
        ]);
    }
}
