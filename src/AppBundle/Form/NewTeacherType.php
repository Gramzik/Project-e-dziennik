<?php

namespace AppBundle\Form;

use AppBundle\Entity\Teacher;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewTeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->setMethod('POST')
            ->add('user', EntityType::class, ['class' => User::class, 'choice_label' => 'username', 'label' => 'Nauczyciel: '])
            ->add('save', SubmitType::class, ['label' => 'Mianuj jako nauczyciela']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Teacher::class]
        );
    }
}