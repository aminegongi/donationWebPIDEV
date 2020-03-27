<?php

namespace NewsletterBundle\Form;

use NewsletterBundle\Entity\NewsHTMLBuilder;
use NewsletterBundle\Entity\NewsletterW;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterWType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('objetMail')
            ->add('corpsID',EntityType::class, array('class'=>NewsHTMLBuilder::class,'choice_label'=>'titre','multiple'=>false) );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NewsletterBundle\Entity\NewsletterW'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'newsletterbundle_newsletterw';
    }


}
