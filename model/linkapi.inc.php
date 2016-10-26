<?php
/**
 * Created by PhpStorm.
 * User: snark | itfrogs.ru
 * Date: 10/26/16
 * Time: 1:44 AM
 */

namespace vendors\Model;

use vendors\Model\Orm\Link;

/**
 * Класс для организации выборок ORM объекта.
 * В этом классе рекомендуется также реализовывать любые дополнительные методы, связанные с заявленной в конструкторе моделью
 */
class LinkApi extends \RS\Module\AbstractModel\EntityList
{
    function __construct()
    {
        parent::__construct(new Link(), array(
            'multisite' => true,
        ));
    }

}