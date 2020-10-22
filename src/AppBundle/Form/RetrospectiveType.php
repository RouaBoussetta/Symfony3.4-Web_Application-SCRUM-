<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class RetrospectiveType extends AbstractType
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
            ->add('startdoing', TextareaType::class, array(
                'label'=> 'Start doing',
                'attr'=> array(
                    'class'=>'form-control')))
            ->add('stopdoing', TextareaType::class, array(
                'label'=> 'Stop doing',
                'attr'=> array(
                    'class'=>'form-control')))
        ->add('continuedoing', TextareaType::class, array(
        'label'=> 'Continue doing',
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
            'data_class' => 'Doc\DocumentBundle\Entity\Retrospective'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'doc_documentbundle_retrospective';
    }


}
