<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ParticipantType extends AbstractType
{//a cette endroit on crée les parametre pour le formulaire pour mon profil avec chaque champ avec ses prompre donée
    //comme texttype pour les text paswordtype pour les mot de passe et numbertype pour le num de telephone
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 2,
                    'maxlength' => 70,
                ],
                'label' => 'nom',
                'label_attr' => [
                    'class'=>'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 70]),
                ]

            ])
            ->add('prenom',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 2,
                    'maxlength' => 70,
                ],
                'label' => 'prenom',
                'label_attr' => [
                    'class'=>'form-label mt-4',
                ],
                'constraints' => [
                    new assert\Length(['min' => 2, 'max' => 70]),
                ]

            ])
            ->add('telephone',NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 10,
                    'maxlength' => 10,
                ],
                'label' => 'telephone',
                'label_attr' => [
                    'class'=>'form-label mt-4',
                ],
                'constraints' => [
                    new assert\Length(['min' => 10, 'max' => 10]),
                ]

            ])
            ->add('mail',EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 2,
                    'maxlength' => 70,
                ],
                'label' => 'mail',
                'label_attr' => [
                    'class'=>'form-label mt-4',
                ],
                'constraints' => [
                    new assert\Length(['min' => 2, 'max' => 70]),
                ]


            ])
            ->add('motPasse',PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 2,
                    'maxlength' => 70,
                ],
                'label' => 'votre nouveau mot de passe',
                'label_attr' => [
                    'class'=>'form-label mt-4',
            ]])
            ->add('pseudo',TextType::class, [
        'attr' => [
            'class' => 'form-control',
            'minlength' => 2,
            'maxlength' => 70,
        ],
        'label' => 'pseudo',
        'label_attr' => [
            'class'=>'form-label mt-4',
        ],
        'constraints' => [
            new assert\Length(['min' => 2, 'max' => 70])
        ]])//ici on utiliser entitytype pour pouvoir generer automatiquement le scorwling pour la liste des campus
            ->add('campus', EntityType::class, [
                'label' => 'campus',
                'class' => Campus::class,
                'choice_label' => 'nom',]);
            $builder->add('enregister', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);

    }
//ici c'est juste le resolver qui fais ses verification !
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
