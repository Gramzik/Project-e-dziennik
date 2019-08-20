<?php

namespace AppBundle\Form;


use AppBundle\Entity\Classes;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddClassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('name', TextType::class, ['label' => 'Nazwa klasy.'])
            ->add('educator', EntityType::class, ['class' => User::class,
                'label' => 'Wychowawca.',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('u')
                        ->where('u.roles LIKE :role1')
                        ->setParameter('role1','%ROLE_EDUCATOR%');
                },
                'choice_label' => 'username'
            ])
            ->add('save', SubmitType::class, ['label' => 'Dodaj klasę.']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Classes::class]
        );
    }
}