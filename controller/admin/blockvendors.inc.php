<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/

namespace Vendors\Controller\Admin;

use vendors\Model\LinkApi;
use vendors\Model\Orm\Link;
use vendors\Model\Orm\Vendor;
use vendors\Model\VendorApi;

/**
* Контроллер блока тегов
* @ingroup Tags
*/
class BlockVendors extends \RS\Controller\Admin\Block
{
    protected
        $result,
        /**
         * @var VendorApi $api
         */
        $api;

    function init()
    {
        $this->api = new VendorApi();
        $this->result = new \RS\Controller\Result\Standart($this);
    }
    
    function actionIndex()
    {
        if (!isset($this->param['type']) || !isset($this->param['linkid'])) {
            throw new \RS\Controller\ParameterException(t('Не заданы параметры type или linkid'));
        }
        $vendors = $this->api->getAssocList('id');

        $link_api = new LinkApi();
        /**
         * @var Vendor $vendor
         */


        foreach ($vendors as &$vendor) {
            $v = $vendor->getValues();
            $link = \RS\Orm\Request::make()
                ->select()
                ->from(new Link())
                ->where(array(
                    'link_id' => $this->param['linkid'],
                    'vendor_id' => $v['id'],
                ))
                ->object();
            if ($link) {
                $link = $link->getValues();
                $vendor->link = $link;
            }
        }

        $this->view->assign('vendors', $vendors);
        $this->view->assign('type', $this->param['type']);
        $this->view->assign('linkid', $this->param['linkid']);
        return $this->fetch('form.tpl');
    }

    function actionSaveLinks()
    {
        $current_site = \RS\Site\Manager::getSite();
        $type = $this->url->request('type', TYPE_STRING);
        $link_id = $this->url->request('link_id', TYPE_INTEGER);
        $vendors = $this->url->request('vendors', TYPE_ARRAY);
        $link_api = new LinkApi();
        $data = array();
        foreach ($vendors as $key => $vendor) {
            $data[$key] = array(
                'site_id'   => $current_site['id'],
                'link_id'   => $link_id,
                'url'       => $vendor['url'],
            );
            if (isset($vendor['id'])) {
                $data[$key]['id'] = $vendor['id'];
            }
        }

        $link_api->multiUpdate($data);
    }
}

