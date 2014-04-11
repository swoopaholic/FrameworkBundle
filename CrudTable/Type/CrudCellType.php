<?php
/**
 * Created 04-02-14 21:13
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
