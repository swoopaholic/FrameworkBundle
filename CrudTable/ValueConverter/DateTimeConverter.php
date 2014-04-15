<?php
/*
 * (c) Netvlies Internetdiensten
 *
 * Author Danny Dörfel <ddorfel@netvlies.nl>
 * Created: 15/04/14 13:08 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle\CrudTable\ValueConverter;

use Swoopaholic\Bundle\FrameworkBundle\CrudTable\ValueConverterInterface;

class DateTimeConverter implements ValueConverterInterface
{
    private $format;

    public function __construct($format = 'Y-m-d H:i:s')
    {
        $this->format = $format;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function convert($value)
    {
        if (! $value instanceof \DateTime) {
            throw new \InvalidArgumentException('DateTimeConverter only accepts DateTime objects');
        }

        return $value->format($this->format);
    }
}
