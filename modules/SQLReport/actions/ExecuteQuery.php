<?php
require_once 'modules/SQLReport/models/SqlHelper.php';

class SQLReport_ExecuteQuery_Action extends Vtiger_Action_Controller {
    public function checkPermission(Vtiger_Request $request) {
        return true;
    }

    public function process(Vtiger_Request $request) {
        $db = PearDatabase::getInstance();
        $sql = trim($request->get('sql'));

        if (!$this->isAllowed($sql)) {
            echo json_encode(['success' => false, 'error' => 'Обнаружена потенциально опасная команда']);
            return;
        }

        $mode = $request->get('mode');
        if (in_array($mode, ['export_csv', 'export_xls', 'export_xlsx'])) {
            $this->export($db, SQLReport_SqlHelper::normalizeSql($sql), $mode);
            return;
        }

        $limitedSql = SQLReport_SqlHelper::wrapWithLimit($sql, 1001);
        $res = $db->query($limitedSql);
        $rows = [];
        $truncated = false;
        while ($r = $db->fetch_array($res)) {
            if (count($rows) >= 1000) {
                $truncated = true;
                break;
            }
            $rows[] = array_filter($r, function ($key) {
                return !is_int($key);
            }, ARRAY_FILTER_USE_KEY);
        }

        echo json_encode([
            'success'   => true,
            'rows'      => $rows,
            'truncated' => $truncated,
        ]);
    }

    protected function export(PearDatabase $db, string $sql, string $mode): void {
        $filenameBase = 'sqlreport_' . date('Ymd_His');
        $res = $db->query($sql);
        $rows = SQLReport_SqlHelper::fetchAssocRows($db, $res);

        switch ($mode) {
            case 'export_xls':
            case 'export_xlsx':
                $extension = $mode === 'export_xlsx' ? 'xlsx' : 'xls';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="' . $filenameBase . '.' . $extension . '"');
                echo $this->generateXlsContent($rows);
                break;
            default:
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename="' . $filenameBase . '.csv"');
                $out = fopen('php://output', 'w');
                if (!empty($rows)) {
                    fputcsv($out, array_keys(reset($rows)));
                }
                foreach ($rows as $r) {
                    fputcsv($out, array_values($r));
                }
                fclose($out);
        }
    }

    protected function generateXlsContent(array $rows): string {
        if (empty($rows)) {
            return '';
        }

        $headers = array_keys(reset($rows));
        $html = '<table border="1">';
        $html .= '<thead><tr>';
        foreach ($headers as $header) {
            $html .= '<th>' . htmlspecialchars($header, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($headers as $header) {
                $value = isset($row[$header]) ? $row[$header] : '';
                $html .= '<td>' . htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }

    protected function isAllowed($sql) {
        return SQLReport_SqlHelper::isSafe($sql);
    }
}
