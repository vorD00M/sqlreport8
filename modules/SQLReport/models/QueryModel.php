<?php
class SQLReport_QueryModel {
    public static function all() {
        $db = PearDatabase::getInstance();
        $res = $db->pquery('SELECT sqlreportid, name, sql_query, description FROM vtiger_sqlreport ORDER BY sqlreportid DESC', []);
        $out = [];
        while ($r = $db->fetch_array($res)) $out[] = $r;
        return $out;
    }
}
