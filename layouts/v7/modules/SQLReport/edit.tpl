<link rel="stylesheet" href="modules/SQLReport/resources/js/codemirror/lib/codemirror.css">
<script src="modules/SQLReport/resources/js/codemirror/lib/codemirror.js"></script>
<script src="modules/SQLReport/resources/js/codemirror/mode/sql/sql.js"></script>

<form onsubmit="return false;" class="sqlreport-editor-form">
  <div class="form-group">
    <label for="reportName">Название отчёта</label>
    <input type="text" id="reportName" class="form-control" placeholder="Введите название">
  </div>
  <textarea id="queryTextarea"></textarea>
  <div class="btn-group" style="margin-top:10px;">
    <button type="button" class="btn btn-success" onclick="run()">Выполнить</button>
    <button type="button" class="btn btn-primary" onclick="saveQuery()">Сохранить</button>
    <button type="button" class="btn btn-default" onclick="exportCsv()">Экспорт CSV</button>
    <button type="button" class="btn btn-default" onclick="exportXls()">Экспорт XLS</button>
    <button type="button" class="btn btn-default" onclick="exportXlsx()">Экспорт XLSX</button>
  </div>
</form>

<div id="out" style="margin-top:15px;"></div>

<style>
  .CodeMirror {
    height: 360px;
    border: 1px solid #ccc;
  }
  .cm-error-text {
    background: rgba(255, 0, 0, 0.15);
    border-bottom: 1px dotted #f00;
  }
</style>

<script src="modules/SQLReport/resources/js/editor.js"></script>
