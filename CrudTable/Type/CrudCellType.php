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
use Swoopaholic\Component\Table\Type\CellType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CrudCellType extends CellType
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

    public function getName()
    {
        return 'crud_cell';
    }
}
