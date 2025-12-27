<?php
require_once 'modules/SQLReport/models/SqlHelper.php';
require_once 'modules/SQLReport/SQLReport.php';

class SQLReport_SaveQuery_Action extends Vtiger_Action_Controller {
    public function checkPermission(Vtiger_Request $request) {
        return true;
    }

    public function process(Vtiger_Request $request) {
        $name = trim($request->get('name'));
        $sql = trim($request->get('sql'));

        if ($name === '') {
            echo json_encode(['success' => false, 'error' => 'Введите название отчёта']);
            return;
        }

        if (!SQLReport_SqlHelper::isSafe($sql)) {
            echo json_encode(['success' => false, 'error' => 'Обнаружена потенциально опасная команда']);
            return;
        }

        try {
            $focus = new SQLReport();
            $focus->column_fields['name'] = $name;
            $focus->column_fields['sql_query'] = SQLReport_SqlHelper::normalizeSql($sql);
            $focus->column_fields['description'] = '';
            $focus->save('SQLReport');

            echo json_encode(['success' => true, 'id' => $focus->id]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
