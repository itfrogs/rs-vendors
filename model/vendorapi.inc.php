<?php
namespace vendors\Model;
use vendors\Model\Orm\Vendor;

/**
* Класс для организации выборок ORM объекта.
* В этом классе рекомендуется также реализовывать любые дополнительные методы, связанные с заявленной в конструкторе моделью
*/
class VendorApi extends \RS\Module\AbstractModel\EntityList
{
    function __construct()
    {
        parent::__construct(new Vendor(), array(
            'multisite' => true,
            'nameField' => 'title',
        ));
    }
    
    function getProductLinks($product_id)
    {
        //Загружаем список линков товара и поставщиков
        return \rs\Orm\Request::make()
                    ->from(new \vendors\Model\Orm\Link)
                    ->where(array(
                        'link_id' => $product_id
                    ))->objects(null, 'vendor_id');
    }
    
}