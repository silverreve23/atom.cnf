<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MainAdminController;

use Excel;
use App\Model\CategoryDescription;
use Exception;

#-------------------------------------------------------------------------------
# @class XMLImportProductController
# Class parse xml file to be import product
#-------------------------------------------------------------------------------
class XMLImportProductController extends MainAdminController{

    #---------------------------------------------------------------------------
    # @method __construct
    # Method first Initialization
    #---------------------------------------------------------------------------
    public function __construct(){

        $this->menu = new MenuController();
        parent::__construct();

    }

    #---------------------------------------------------------------------------
    # @method index
    # Method handle xml import page
    #---------------------------------------------------------------------------
    public function index(){

        $language_id = $this->language_id;

        $data['menu'] = $this->menu->getAdminMenu();
        $data['text_head_title'] = trans('admin/xml_product.head_title');

        $data['breadcrumbs'] = array(
            array(
                'name' => trans('admin/admin.home'),
                'url' => url('adminpanel')
            ),
            array(
                'name'=>trans('admin/xml_product.head_title'),
                'url'=>''
            )
        );

        return view('admin.xml.xml_product', $data);

    }

    #---------------------------------------------------------------------------
    # @method parse
    # @action post
    # @params request()
    # Method gilen post data
    # Method parse xml file
    #---------------------------------------------------------------------------
    public function parse(){

        if(!$xmlFile = request()->xml_file)
            return back();

        if(!$xmlFile->isValid())
            return back();

        $categoryAll = CategoryDescription::categoryAllName();

        Excel::load($xmlFile, function($reader){

            // $results = $reader->get();
            $results = $reader->toObject();
            // $results = $results->toObject();

            dd($results);

            // if(!count($results->getItems()))
            //     return back();

            $categoryAll = CategoryDescription::categoryAllName();

            if(!$categoryAll)
                throw new Exception("Table Categories Empty!");

            dump($categoryAll);

            foreach($results as $value){

                if(!isset($value['category']))
                    $this->assertTrue(false);

                $dataProductDump[] = $value;

            }

        });

        return back();

    }

}
