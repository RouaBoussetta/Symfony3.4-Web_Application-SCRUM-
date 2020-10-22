<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class PlanningType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
            'label'=> 'File Name',
            'attr'=> array(
                'class'=>'form-control')
        ))
            ->add('analyse', TextareaType::class, array(
                'label'=> 'Analyse Project',
                'attr'=> array(
                    'class'=>'form-control')
            ))
            ->add('evaluate', TextareaType::class, array(
                'label'=> 'Evaluate process',
                'attr'=> array(
                    'class'=>'form-control')
            ))
            ->add('product', TextType::class, array(
                'label'=> 'Project',
                'attr'=> array(
                    'class'=>'form-control')
            ))
            ->add('sprintgoal', TextareaType::class, array(
                'label'=> 'Sprint Goals ',
                'attr'=> array(
                    'class'=>'form-control')
            ))
            ->add('tasks', TextareaType::class, array(
                'label'=> 'Tasks list',
                'attr'=> array(
                    'class'=>'form-control')
            ))
        ->add('idType',HiddenType::class, array(
        'label'=> 'Completed Hours',
        'required'=> 'false',
        'empty_data' => '1',
        'attr'=> array(
            'class'=>'form-control')
    ))
            ->add('captcha', CaptchaType::class, array(
                'label'=> 'Captcha here',
                'attr'=> array(
                    'class'=>'form-control')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Planning'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'doc_documentbundle_planning';
    }


}
