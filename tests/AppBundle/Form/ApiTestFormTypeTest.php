<?php
/**
 * Form for API Testing functions.
 *
 * @author Saswati
 *
 * @category FormType
 */
namespace Tests\AppBundle\Form;

use AppBundle\Form\Type\ApiTestFormType;
use Symfony\Component\Form\Test\TypeTestCase;



class ApiTestFormTypeTest extends TypeTestCase
{
    
    public function testSubmitValidData()
    {
        $formData = array(
            'test' => 'test',
            'test2' => 'test2'
        );

        
        // $objectToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(ApiTestFormType::class, $objectToCompare);

       
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($object, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
