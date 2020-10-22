<?php

namespace AppBundle\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DailyscrumType extends AbstractType
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
            ->add('yesterdaywork',TextareaType::class, array(
                'label'=> 'Yesterday work',
                'attr'=> array('class'=>'form-control')
            ))
            ->add('todayplan',TextareaType::class, array(
                'label'=> 'Today plan',
                'attr'=> array('class'=>'form-control')
            ))
            ->add('blockers',TextareaType::class, array(
                'label'=> 'Work blockers',
                'attr'=> array('class'=>'form-control')
            ))
            ->add('hrsbrunt',IntegerType::class, array(
                'label'=> 'Brunt Hours',
                'attr'=> array(
                    'class'=>'form-control')
            ))
            ->add('hrscompleted',IntegerType::class, array(
                'label'=> 'Completed Hours',
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
                    'class'=>'form-control')));    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Dailyscrum'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_dailyscrum';
    }


}
