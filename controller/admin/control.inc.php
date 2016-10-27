<?php
namespace vendors\Controller\Admin;

use \RS\Html\Table\Type as TableType,
    \RS\Html\Toolbar\Button as ToolbarButton,
    \RS\Html\Filter,
    \RS\Html\Table;
use vendors\Model\VendorApi;

/**
* Контроллер Управление списком магазинов сети
*/
class Control extends \RS\Controller\Admin\Crud
{
    function __construct()
    {
        //Устанавливаем, с каким API будет работать CRUD контроллер
        parent::__construct(new VendorApi());
    }
    
    function helperIndex()
    {
        $helper = parent::helperIndex(); //Получим helper по-умолчанию
        $helper->setTopTitle('Админ. часть модуля vendors'); //Установим заголовок раздела
        
        //Отобразим таблицу со списком объектов
        $helper->setTable(new Table\Element(array(
            'Columns' => array(
                    new TableType\Text('title', 'Название', array('Sortable' => SORTABLE_BOTH, 'href' => $this->router->getAdminPattern('edit', array(':id' => '@id')), 'LinkAttr' => array('class' => 'crud-edit'))),
                    new TableType\Actions('id', array(
                            new TableType\Action\Edit($this->router->getAdminPattern('edit', array(':id' => '~field~'))),
                        ),
                        array('SettingsUrl' => $this->router->getAdminUrl('tableOptions'))
                    ), 
        ))));
        
        //Добавим фильтр значений в таблице по названию
        $helper->setFilter(new Filter\Control( array(
            'Container' => new Filter\Container( array( 
                                'Lines' =>  array(
                                    new Filter\Line( array('items' => array(
                                            new Filter\Type\Text('title', 'Название', array('SearchType' => '%like%')),
                                        )
                                    ))
                                ),
                            ))
        )));

        return $helper;
    }
}
