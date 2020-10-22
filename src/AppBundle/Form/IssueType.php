<?php

namespace AppBundle\Form;

use AppBundle\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IssueType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('project',EntityType::class,['class'=>Project::class,'choice_label'=>'projecttitle','multiple'=>false])
            ->add('type',ChoiceType::class,array(
                'choices'=>array(
                    'Story'=>'Story',
                    'Bug'=>'Bug',
                    'SubTask'=>'SubTask',
                    'Task'=>'Task',
                )))
            ->add('description')
            ->add('summary')
            ->add('priority',ChoiceType::class,array(
                'choices'=>array(
                    'Highest'=>'Highest',
                    'High'=>'High',
                    'Medium'=>'Medium',
                    'Low'=>'Low',
                    'Lowest'=>'Lowest',
                )))
            ->add('status',ChoiceType::class,array(
                'choices'=>array(
                    'To Do'=>'To Do',
                    'In Progress'=>'In Progress',
                    'Done'=>'Done',
                )))
            ->add('save',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Issue'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'Appbundle_issue';
    }


}
