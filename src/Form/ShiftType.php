<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Shift;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('employe', EntityType::class,[
                'class' => Employe::class,
                'label' => 'Employé',
                'choice_label' =>  function (Employe $employe) {

                    return $employe->getNom() .' '. $employe->getPrenom();
                },
                'placeholder' => 'Choisissez votre nom',
            ])
            ->add('chantier')
            ->add('date', DateType::class,[
                'widget' => 'single_text',
                'data' => new \DateTime('now')
                ])
            ->add('heure_de_debut',TimeType::class,[
                'label_format'=> 'Heure début '
            ])
            ->add('heure_de_fin',TimeType::class,[
                'label_format'=> 'Heure fin '
            ])
            ->add('heures_normales')
            ->add('heures_supp')
            ->add('heures_nuit')
            ->add('ferie', null, ['label' => 'Ferié'])
            ->add('maladie')
            ->add('cp')
            ->add('autre')
            ->add('confirmer', SubmitType::class,)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shift::class,

        ]);
    }
}
