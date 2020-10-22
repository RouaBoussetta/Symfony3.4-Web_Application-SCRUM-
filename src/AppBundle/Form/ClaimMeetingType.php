<?php

namespace AppBundle\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use AppBundle\Entity\Meeting;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClaimMeetingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('tel',TextType::class,array(

                'attr' => array(
                    'placeholder' => "Enter your phone number !"
                )))
            ->add('available', ChoiceType::class,array('choices'=> array(
                'i will be late'=>'i will be late',
                'I am not available'=>'I am not available',
                'i m sick'=>'im sick'
            )))
            ->add('other',TextareaType::class,array(

                'attr' => array(
                    'placeholder' => "Other... !"
                )))
            ->add('reason',TextareaType::class,array(

                'attr' => array(
                    'placeholder' => "Enter your reason !"
                )))

            ->add('meeting',EntityType::class,['class'=>Meeting::class,'choice_label'=>'titleMeeting'])
            ->add('captcha', CaptchaType::class)

            ->add('save',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ClaimMeeting'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_claimmeeting';
    }


}
