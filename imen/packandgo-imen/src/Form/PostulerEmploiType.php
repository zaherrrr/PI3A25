<?php

namespace App\Form;

use App\Entity\PostulerEmploi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostulerEmploiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('motivation')
            ->add('pdfcv',FileType::class, array('data_class' => null,'required' => false))
            ->add('Enregistrer',SubmitType::class,[
                'attr' => ['class' => 'btn btn-primary'],
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostulerEmploi::class,
        ]);
    }
}
