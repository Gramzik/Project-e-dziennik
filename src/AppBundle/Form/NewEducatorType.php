<?php


namespace AppBundle\Form;


use AppBundle\Entity\Educator;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewEducatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('user', EntityType::class, ['class' => User::class, 'choice_label' => 'username', 'label' => 'Wychowawca: '])
            ->add('save', SubmitType::class, ['label' => 'Mianuj jako wychowawcę']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Educator::class]
        );
    }
}