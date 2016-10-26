<?php
namespace vendors\Config;

use \RS\Orm\Type;
use vendors\Model\VendorApi;
use vendors\Model\Orm;


/**
* Класс содержит обработчики событий, на которые подписан модуль
*/
class Handlers extends \RS\Event\HandlerAbstract
{
    /**
    * Добавляет подписку на события
    * 
    * @return void
    */
    function init()
    {
        $this
            ->bind('getroute')  //событие сбора маршрутов модулей
            ->bind('getmenus') //событие сбора пунктов меню для административной панели
            ->bind('orm.init.catalog-product')
            ->bind('orm.afterwrite.catalog-product');
    }

    public static function ormInitCatalogProduct(\Catalog\Model\Orm\Product $orm_product)
    {
        $orm_product->getPropertyIterator()->append(array(
                t('Поставщики'),
                'vendors' => new \RS\Orm\Type\ArrayList(array(
                    'template' => '%vendors%/tab_vendors.tpl',
                    'vendorApi' => new VendorApi(),
                )),                
            )
        );
    }
    
    /**
    * Событие вызывается, когда товар гарантировано был провалидирован и сохранен.
    * 
    * @param array $params
    */
    public static function ormAfterWriteCatalogProduct($params)
    {
        /**
        * @var \Catalog\Model\Orm\Product
        */
        $product = $params['orm'];
        $vendors = $product['vendors']; //Здесь будет массив, который пришел нам из POST
        //Делаем с ним что угодно, сохраняем например.
        
        if ($product->isModified('vendors')) {
            
            //Пока игнорируем обновление, тупо пересоздаем линки
            //Удаляем старые
            \RS\Orm\Request::make()
                ->delete()
                ->from(new \Vendors\Model\Orm\Link())
                ->where(array(
                    'link_id' => $product['id']
                ))->exec();
                
            //Создаем новые
            foreach($vendors as $vendor_id => $vendor_link) {
                if ($vendor_link['url'] != '') {
                    $link = new \Vendors\Model\Orm\Link();
                    $link['vendor_id'] = $vendor_id;
                    $link['link_id'] = $product['id'];
                    $link['url'] = $vendor_link['url'];
                    $link->insert();
                }
            }
        }
    }

    /**
    * Возвращает маршруты данного модуля. Откликается на событие getRoute.
    * @param array $routes - массив с объектами маршрутов
    * @return array of \RS\Router\Route
    */
    public static function getRoute(array $routes) 
    {
        $routes[] = new \RS\Router\Route('vendors-front-ctrl',
        array(
            '/testmodule-vendors/'
        ), null, 'Роут модуля vendors');
        
        return $routes;
    }

    /**
    * Возвращает пункты меню этого модуля в виде массива
    * @param array $items - массив с пунктами меню
    * @return array
    */
    public static function getMenus($items)
    {
        $items[] = array(
            'title' => t('Поставщики'),
            'alias' => 'vendors-control',
            'link' => '%ADMINPATH%/vendors-control/',
            'parent' => 'modules',
            'sortn' => 40,
            'typelink' => 'link',
        );
        return $items;
    }
}