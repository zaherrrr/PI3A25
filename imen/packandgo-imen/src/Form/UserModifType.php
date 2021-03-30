<?php

namespace App\Form;

use App\Entity\Users;
use Doctrine\DBAL\Types\TextType;
use Dompdf\FrameDecorator\Text;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('imageFile',FileType::class,['required'=>false])
            ->add('email')
            ->add('username')
            ->add('password')
            ->add('verifpassword',PasswordType::class)
            ->add('Roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                    'User' => 'ROLE_USER',

                    'Admin' => 'ROLE_ADMIN',
                    'freelancer' => 'ROLE_FREELANCER',
                    'employeur' => 'ROLE_EMPLOYEUR',
                    'employé'=>'ROLE_EMPLOYE'
                ],
            ])->add('Enregistrer',SubmitType::class,[
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
        $builder->get('Roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {

                    return $rolesString;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
