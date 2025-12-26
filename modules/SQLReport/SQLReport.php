<?php
include_once 'vtlib/Vtiger/Module.php';
class SQLReport extends Vtiger_CRMEntity {
    public $table_name = 'vtiger_sqlreport';
    public $table_index = 'sqlreportid';


    public $customFieldTable = [];


    public $tab_name = ['vtiger_crmentity', 'vtiger_sqlreport'];
    public $tab_name_index = [
        'vtiger_crmentity' => 'crmid',
        'vtiger_sqlreport' => 'sqlreportid'
    ];


    public $list_fields = ['Название' => ['sqlreport', 'name']];
    public $list_fields_name = ['Название' => 'name'];


    public $list_link_field = 'name';


    public $search_fields = ['Название' => ['sqlreport', 'name']];
    public $search_fields_name = ['Название' => 'name'];


    public $popup_fields = ['name'];


    public $def_basicsearch_col = 'name';
    public $def_detailview_recname = 'name';


    public $mandatory_fields = ['name', 'sql_query'];


    public $default_order_by = 'name';
    public $default_sort_order = 'ASC';
}
