<link rel="stylesheet" href="modules/SQLReport/resources/js/codemirror/lib/codemirror.css">
<script src="modules/SQLReport/resources/js/codemirror/lib/codemirror.js"></script>
<script src="modules/SQLReport/resources/js/codemirror/mode/sql/sql.js"></script>

<div class="container-fluid">
  <h3>SQL Report</h3>
  <textarea id="queryTextarea" style="width:100%;height:220px;"></textarea>
  <br><br>
  <div class="btn-group">
    <button class="btn btn-primary" type="button" onclick="run()">Run</button>
    <button class="btn btn-default" type="button" onclick="exportCsv()">Export CSV</button>
    <button class="btn btn-default" type="button" onclick="exportXls()">Export XLS</button>
    <button class="btn btn-default" type="button" onclick="exportXlsx()">Export XLSX</button>
  </div>
  <div id="out" style="margin-top:15px;"></div>
</div>

<script src="modules/SQLReport/resources/js/editor.js"></script>
