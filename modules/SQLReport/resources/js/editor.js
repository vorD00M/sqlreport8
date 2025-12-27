var ta = document.getElementById('queryTextarea');
var ed = CodeMirror.fromTextArea(ta, {
  mode: 'text/x-sql',
  lineNumbers: true,
  matchBrackets: true,
  indentWithTabs: true,
  smartIndent: true,
  lineWrapping: true,
});

// Reuse existing global if present to avoid ReferenceError in multi-load scenarios.
var FORBIDDEN_RE = window.FORBIDDEN_RE || /(INSERT|UPDATE|DELETE|TRUNCATE|CREATE|DROP|ALTER)/gi;
window.FORBIDDEN_RE = FORBIDDEN_RE;

function highlightError(sql) {
  var forbidden = new RegExp(FORBIDDEN_RE.source, 'gi');
  var marks = [];
  ed.eachLine(function (line) {
    var text = line.text;
    var match;
    while ((match = forbidden.exec(text)) !== null) {
      var start = { line: ed.getLineNumber(line), ch: match.index };
      var end = { line: ed.getLineNumber(line), ch: match.index + match[0].length };
      marks.push(ed.markText(start, end, { className: 'cm-error-text' }));
    }
  });
  return marks;
}

function clearMarks(marks) {
  if (!marks) return;
  marks.forEach(function (m) { m.clear(); });
}

function run() {
  var sql = ed.getValue();
  clearMarks(window.__forbiddenMarks);

  if (!canProceed(sql)) {
    return;
  }

  fetch('index.php?module=SQLReport&action=ExecuteQuery', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'sql=' + encodeURIComponent(sql)
  }).then(function (r) { return r.json(); }).then(function (d) {
    if (!d.success && d.error) {
      window.__forbiddenMarks = highlightError(sql);
      document.getElementById('out').innerHTML = '<div class="alert alert-danger">' + d.error + '</div>';
      return;
    }

    renderTable(d.rows || [], d.truncated);
  });
}

function renderTable(rows, truncated) {
  var out = document.getElementById('out');
  if (!rows.length) {
    out.innerHTML = '<div class="alert alert-info">Нет данных</div>';
    return;
  }

  var headers = Object.keys(rows[0]);
  var html = '<div class="table-responsive"><table class="table table-bordered table-striped table-sm listViewEntriesTable">';
  html += '<thead><tr>' + headers.map(function (h) { return '<th>' + h + '</th>'; }).join('') + '</tr></thead>';
  html += '<tbody>' + rows.map(function (row) {
    return '<tr>' + headers.map(function (h) { return '<td>' + (row[h] !== undefined ? row[h] : '') + '</td>'; }).join('') + '</tr>';
  }).join('') + '</tbody></table></div>';
  if (truncated) {
    html += '<div class="alert alert-warning">Показаны первые 1000 строк. Для полного экспорта используйте CSV/XLS(X).</div>';
  }
  out.innerHTML = html;
}

function saveQuery() {
  var sql = ed.getValue();
  var nameInput = document.getElementById('reportName');
  var name = nameInput ? nameInput.value.trim() : '';

  if (!name) {
    document.getElementById('out').innerHTML = '<div class="alert alert-danger">Введите название отчёта</div>';
    return;
  }

  if (!canProceed(sql)) {
    return;
  }

  fetch('index.php?module=SQLReport&action=SaveQuery', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'name=' + encodeURIComponent(name) + '&sql=' + encodeURIComponent(sql)
  }).then(function (r) { return r.json(); }).then(function (d) {
    if (!d.success && d.error) {
      document.getElementById('out').innerHTML = '<div class="alert alert-danger">' + d.error + '</div>';
      return;
    }

    document.getElementById('out').innerHTML = '<div class="alert alert-success">Сохранено (ID: ' + d.id + ')</div>';
  });
}

function exportCsv() {
  if (!canProceed(ed.getValue())) {
    return;
  }
  window.location.href = 'index.php?module=SQLReport&action=ExecuteQuery&mode=export_csv&sql=' + encodeURIComponent(ed.getValue());
}

function exportXls() {
  if (!canProceed(ed.getValue())) {
    return;
  }
  window.location.href = 'index.php?module=SQLReport&action=ExecuteQuery&mode=export_xls&sql=' + encodeURIComponent(ed.getValue());
}

function exportXlsx() {
  if (!canProceed(ed.getValue())) {
    return;
  }
  window.location.href = 'index.php?module=SQLReport&action=ExecuteQuery&mode=export_xlsx&sql=' + encodeURIComponent(ed.getValue());
}

function canProceed(sql) {
  var normalized = (sql || '').trim().replace(/[;\\s]+$/g, '');
  clearMarks(window.__forbiddenMarks);

  if (!/^\\s*(with|select)/i.test(normalized) || FORBIDDEN_RE.test(normalized)) {
    window.__forbiddenMarks = highlightError(sql);
    document.getElementById('out').innerHTML = '<div class=\"alert alert-danger\">Обнаружена потенциально опасная команда</div>';
    FORBIDDEN_RE.lastIndex = 0;
    return false;
  }

  FORBIDDEN_RE.lastIndex = 0;
  return true;
}
