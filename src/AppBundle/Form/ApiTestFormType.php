<?php
/**
 * Form for API Testing functions.
 *
 * @author Saswati
 *
 * @category FormType
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ApiTestFormType extends AbstractType
{
    /**
     * API form builder.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('verb', ChoiceType::class, array(
            'choices' => array('GET' => 'GET', 'POST' => 'POST'),
            'required' => true,
        ))
        ->add('content', TextareaType::class, array('required' => true))
        ->add('url', TextType::class, array('required' => true))
            ->add('save', SubmitType::class, array(
                            'attr' => array('class' => 'upload'),
                        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return 'testForm';
    }
}
