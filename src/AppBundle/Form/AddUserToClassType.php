<?php

namespace AppBundle\Form;


use AppBundle\Entity\Classes;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddUserToClassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('pupil', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'label' => 'Uczniowie.',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('u')
                        ->where('u.roles NOT LIKE :roles')
                        ->andWhere('u.class IS NULL')
                        ->setParameters(['roles' => '%ROLE%']);
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Dodaj Ucznia.']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Classes::class]
        );
    }
}