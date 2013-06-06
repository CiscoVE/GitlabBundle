<?php

namespace CiscoSystems\GitlabBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class IssueType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder->add( 'access_id', 'hidden', array(
            'property_path' => false,
        ));
        $builder->add( 'id', 'hidden' );
        $builder->add( 'projectId' );
        $builder->add( 'title' );
        $builder->add( 'description', 'textarea' );
        //$builder->add( 'labels' );
        //$builder->add( 'assignee' );
        //$builder->add( 'milestone' ); // try adding this again, see closed issue https://github.com/gitlabhq/gitlabhq/issues/1244
    }

    public function getDefaultOptions( array $options )
    {
        return array(
            'data_class' => 'CiscoSystems\GitlabBundle\Model\Issue',
        );
    }

    public function getName()
    {
        return 'gitlabissue';
    }
}
