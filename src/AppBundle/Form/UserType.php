<?php
/**
 * Form for Register functions.
 *
 * @author Saswati
 *
 * @category FormType
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    /**
     * API form builder.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
                ->add('last', TextType::class)
                ->add('email', EmailType::class)
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options'  => ['label' => 'Password '],
                    'second_options' => ['label' => 'Repeat Password '],
                ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
