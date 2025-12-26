<?php

class SQLReport_SqlHelper {
    /**
     * Disallowed SQL keywords (checked case-insensitively with word boundaries).
     */
    public const FORBIDDEN_KEYWORDS = [
        'INSERT',
        'UPDATE',
        'DELETE',
        'TRUNCATE',
        'CREATE',
        'DROP',
        'ALTER',
    ];

    /**
     * Normalize SQL text for further processing.
     */
    public static function normalizeSql(string $sql): string {
        return rtrim(trim($sql), ";\r\n\t ");
    }

    /**
     * Check if SQL contains forbidden keywords.
     */
    public static function isSafe(string $sql): bool {
        $normalized = self::normalizeSql($sql);

        if (strpos($normalized, ';') !== false) {
            return false;
        }

        if (!preg_match('/^(WITH|SELECT)\b/i', $normalized)) {
            return false;
        }

        return !preg_match('/\b(' . implode('|', self::FORBIDDEN_KEYWORDS) . ')\b/i', $normalized);
    }

    /**
     * Prepare limited SQL for preview.
     */
    public static function wrapWithLimit(string $sql, int $limit = 1000): string {
        $normalized = self::normalizeSql($sql);
        return "SELECT * FROM (" . $normalized . ") AS sqlreport_src LIMIT " . (int) $limit;
    }

    /**
     * Fetch associative rows from a PearDatabase result resource.
     */
    public static function fetchAssocRows(PearDatabase $db, $result): array {
        $rows = [];
        while ($row = $db->fetch_array($result)) {
            $rows[] = array_filter($row, function ($key) {
                return !is_int($key);
            }, ARRAY_FILTER_USE_KEY);
        }

        return $rows;
    }
}
