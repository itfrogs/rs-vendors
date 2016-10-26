<?php
/**
 * Created by PhpStorm.
 * User: snark | itfrogs.ru
 * Date: 10/26/16
 * Time: 1:37 AM
 */

namespace vendors\Model\Orm;
use \RS\Orm\Type;

/**
 * Объект - поставщик
 */
class Link extends \RS\Orm\OrmObject
{
    protected static
        $table = 'vendors_link';

    function _init()
    {
        parent::_init()->append(array(
            t('Основные'),
            'site_id' => new Type\CurrentSite(),
            'vendor_id' => new Type\Integer(array(
                'description' => t('ID поставщика'),
            )),
            'link_id' => new Type\Integer(array(
                'description' => t('ID товара'),
            )),
            'url' => new Type\Varchar(array(
                'maxLength' => '300',
                'description' => t('Ссылка на данный товар у поставщика'),
            )),
        ));
    }
}