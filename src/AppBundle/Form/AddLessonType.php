<?php

namespace AppBundle\Form;


use AppBundle\Entity\Lesson;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddLessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('subject', TextType::class, ['label' => 'Przedmiot.'])
            ->add('teacher', EntityType::class, ['class' => User::class, 'choice_label'=> 'username',
                'label' => 'Nauczyciel.'])
            ->add('save', SubmitType::class, ['label' => 'Dodaj lekcje.']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Lesson::class]
        );
    }

}