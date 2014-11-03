<?php

namespace Kermesse\KermesseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SalesLinesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateCreated')
            ->add('count')
            ->add('priceUnit')
            ->add('priceTotal')
            ->add('products')
            ->add('sales')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kermesse\KermesseBundle\Entity\SalesLines'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kermesse_kermessebundle_saleslines';
    }
}
