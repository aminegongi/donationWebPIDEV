<?php

namespace EmploiBundle\Form;

use EmploiBundle\Entity\CategorieEmploi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmploisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('description')
            ->add('photo',FileType::class, [
                'label' => 'Image Catégorie Emploi','data_class'=> null,'required' => true])
            ->add('salaire')
            ->add('emplacement',ChoiceType::class,[
                'choices' => [
                    'Tunis' => 'Tunis',
                    'Demande' => 'Demande',
                ]
            ])
            ->add('typeDemploi',ChoiceType::class,[
                'choices' => [
                    'Offre' => 'Offre',
                    'Demande' => 'Demande',
                ]
            ])
            ->add('typeContrat',ChoiceType::class,[
                'choices' => [
                    'Contrat Duree Indeterminee' => 'ContratDureeIndeterminee',
                    'Contrat duree determinee' => 'Contratdureedeterminee',
                    'Contrat Travail Temporaire' => 'ContratTravailTemporaire',
                    'Contrat Apprentissage' => 'ContratApprentissage',
                    'Contrat Professionnalisation' => 'ContratProfessionnalisation',
                    'Contrat Unique Insertion' => 'ContratUniqueInsertion',
                ]
            ])
            ->add('idcategorie',EntityType::class, array('class'=>CategorieEmploi::class,'choice_label'=>'titre_categorie','multiple'=>false) );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EmploiBundle\Entity\Emplois'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'emploibundle_emplois';
    }


}
