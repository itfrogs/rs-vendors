<?php
namespace vendors\Controller\Front;

/**
* Фронт контроллер
*/
class Ctrl extends \RS\Controller\Front
{
    function actionIndex()
    {
        return $this->result->setTemplate('vendors_page.tpl');
    }
}
?>