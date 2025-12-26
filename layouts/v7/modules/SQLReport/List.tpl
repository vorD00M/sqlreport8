<link rel="stylesheet" href="modules/SQLReport/resources/js/codemirror/lib/codemirror.css">
<script src="modules/SQLReport/resources/js/codemirror/lib/codemirror.js"></script>
<script src="modules/SQLReport/resources/js/codemirror/mode/sql/sql.js"></script>

<div class="container-fluid">
  <h3>SQL Report</h3>
  <textarea id="queryTextarea" style="width:100%;height:220px;"></textarea>
  <br><br>
  <button class="btn btn-primary" type="button" onclick="runSqlReport()">Run</button>
  <button class="btn btn-default" type="button" onclick="exportCsvReport()">Export CSV</button>
  <pre id="out" style="margin-top:15px;"></pre>
</div>

<script src="modules/SQLReport/resources/js/editor.js"></script>
