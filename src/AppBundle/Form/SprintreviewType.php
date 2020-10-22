<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class SprintreviewType extends AbstractType
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
                    'class'=>'form-control')))
            ->add('projectname', TextType::class, array(
                'label'=> 'Project Name',
                'attr'=> array(
                    'class'=>'form-control')))
            ->add('thingstodemo', TextareaType::class, array(
                'label'=> 'Things to demo',
                'attr'=> array(
                    'class'=>'form-control')))
            ->add('quickupdates', TextareaType::class, array(
                'label'=> 'Quick Updates',
                'attr'=> array(
                    'class'=>'form-control')))
        ->add('whatisnext', TextareaType::class, array(
        'label'=> 'What is next',
        'attr'=> array(
            'class'=>'form-control')))
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
            'data_class' => 'Doc\DocumentBundle\Entity\Sprintreview'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'doc_documentbundle_sprintreview';
    }


}
