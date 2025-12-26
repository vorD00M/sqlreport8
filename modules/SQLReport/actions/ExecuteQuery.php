<?php
class SQLReport_ExecuteQuery_Action extends Vtiger_Action_Controller {
    public function checkPermission(Vtiger_Request $request) { return true; }

    public function process(Vtiger_Request $request) {
        $db = PearDatabase::getInstance();
        $sql = $request->get('sql');
        if (!$this->isAllowed($sql)) {
            echo json_encode(['success'=>false,'error'=>'Обнаружена потенциально опасная команда']);
            return;
        }

        if ($request->get('mode') === 'export_csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="sqlreport.csv"');
            $out = fopen('php://output','w');
            $res = $db->query($sql);
            $first=true;
            while($r=$db->fetch_array($res)){
                if($first){ fputcsv($out,array_keys($r)); $first=false; }
                fputcsv($out,array_values($r));
            }
            fclose($out);
            return;
        }

        $res = $db->query($sql . ' LIMIT 1000');
        $rows=[];
        while($r=$db->fetch_array($res)) $rows[]=$r;
        echo json_encode(['success'=>true,'rows'=>$rows]);
    }

    protected function isAllowed($sql){
        if (strpos($sql,';')!==false) return false;
        if (!preg_match('/^\s*(WITH|SELECT)\b/i',$sql)) return false;
        foreach(['INSERT','UPDATE','DELETE','DROP','ALTER','CREATE','TRUNCATE'] as $k){
            if (preg_match('/\b'.$k.'\b/i',$sql)) return false;
        }
        return true;
    }
}
