<?php
/*
 * This file is part of the Swoopaholic Framework Bundle.
 *
 * (c) Danny Dörfel <danny@swoopaholic.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
