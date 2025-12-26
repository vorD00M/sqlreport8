<?php
class SQLReport_QueryModel {
    public static function all() {
        $db = PearDatabase::getInstance();
        $res = $db->pquery('SELECT * FROM vtiger_sqlreport ORDER BY id DESC', []);
        $out = [];
        while ($r = $db->fetch_array($res)) $out[] = $r;
        return $out;
    }
}
