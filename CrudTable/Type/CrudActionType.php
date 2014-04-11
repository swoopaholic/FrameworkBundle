<?php
/**
 * Created 04-02-14 21:13
 */
namespace Swoopaholic\Bundle\FrameworkBundle\CrudTable\Type;

use Swoopaholic\Component\Table\TableInterface;
use Swoopaholic\Component\Table\TableView;
use Swoopaholic\Component\Table\Type\BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CrudActionType extends BaseType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(
            array(
                'icon' => null,
                'url' => null,
            )
        );
        $resolver->setAllowedValues(array());
        $resolver->setAllowedTypes(array());
    }

    public function buildView(TableView $view, TableInterface $table, array $options)
    {
        parent::buildView($view, $table, $options);

        $view->vars['icon'] = $options['icon'];
        $view->vars['url'] = $options['url'];
    }

    public function getName()
    {
        return 'crud_action';
    }
}
