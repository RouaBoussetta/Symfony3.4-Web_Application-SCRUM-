<?php

namespace AppBundle\Form;

use AppBundle\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ReleasesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('description')
            ->add('project',EntityType::class,['class'=>Project::class,'choice_label'=>'projecttitle','multiple'=>false])
            ->add('startDate',ChoiceType::class,array(
                'choices'=>array(
                    'As early as possible'=>'As early as possible',
                    'fixed Date'=>'fixed Date',
                )))
            ->add('releaseDate',ChoiceType::class,array(
                'choices'=>array(
                    'After All issues are completed'=>'After All issues are completed',
                    'fixed Date'=>'fixed Date',
                )))
            ->add('save',SubmitType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Releases'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'Appbundle_releases';
    }


}
