<?php

namespace AppBundle\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('titleMeeting')
            ->add('goal',TextareaType::class)
            ->add('issues',TextareaType::class)
            ->add('project',EntityType::class,['class'=>Project::class,'choice_label'=>'projecttitle','multiple'=>false])

            ->add('type',ChoiceType::class,array(
                'choices'=>array(
                    'Daily'=>'Daily',
                    'Retrospective'=>'Retrospective',
                    'Sprint'=>'Sprint',
                    'Review'=>'Review',
                )))
            ->add('date')
            ->add('time')
            ->add('users',EntityType::class,['class'=>User::class,'choice_label'=>'username','multiple'=>true])
            ->add('duration')
            ->add('location')

            ->add('captcha', CaptchaType::class)
            ->add('save',SubmitType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Meeting'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_meeting';
    }


}
