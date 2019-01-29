<?php
/**
 * Form for Login functions.
 *
 * @author Saswati
 *
 * @category FormType
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LoginFormType extends AbstractType
{
    /**
     * API form builder.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class)
                ->add('password', PasswordType::class);
    }
    
    /**
     * Returns the name of this type.
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_user';
    }


}
