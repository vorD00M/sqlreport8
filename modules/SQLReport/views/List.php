<?php
require_once 'modules/SQLReport/models/QueryModel.php';

class SQLReport_List_View extends Vtiger_Index_View {
    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);
        $viewer->assign('QUERIES', SQLReport_QueryModel::all());
        $viewer->view('List.tpl', $request->getModule());
    }
}
