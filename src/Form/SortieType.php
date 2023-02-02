<?php

namespace App\Form;

use App\Entity\lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nom',null, ['label' => 'Titre de la sortie'])

            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Débute le...',
                'html5' => true,
                'widget' => 'single_text',
            ])

            ->add('duree', IntegerType::class, ['label' => 'Durée de la sortie (en minute)'])


            //todo : date pas datetype
            ->add('dateLimiteInscription', DateType::class, [
                'label' => "Date limite d'inscription",
                'html5' => true,
                'widget' => 'single_text',
            ])

            ->add('nbInscriptionsMax', IntegerType::class, ['label' => 'Nombre maximum de participants a la sortie'])

            ->add('infosSortie', null, ['label' => "Plus d'infos sur la sortie"])


            ->add('lieu', EntityType::class, [
                'label' => 'Lieu',
                'class' => lieu::class,
                'choice_label' => 'nom',])

                //todo : afficher campus du user

            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('publish', SubmitType::class, ['label' => 'Publier'])
            ->add('delete', SubmitType::class, ['label' => 'Supprimer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
