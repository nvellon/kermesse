<?php

namespace Kermesse\KermesseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SalesProductsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('products', 'entity', array('class' => 'KermesseBundle:Products', 'property' => 'name', 'disabled' => false))
            ->add('priceUnit', 'number', array('disabled' => true, 'attr' => array('class' => 'price')))
            ->add('count', 'integer')
            ->add('priceTotal', 'money', array('currency' => '', 'disabled' => true))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kermesse\KermesseBundle\Entity\SalesLines',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kermesse_kermessebundle_sales_products';
    }
}