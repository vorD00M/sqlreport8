<link rel="stylesheet" href="modules/SQLReport/resources/js/codemirror/lib/codemirror.css">
<script src="modules/SQLReport/resources/js/codemirror/lib/codemirror.js"></script>
<script src="modules/SQLReport/resources/js/codemirror/mode/sql/sql.js"></script>

<form>
  <textarea id="queryTextarea"></textarea>
  <button type="button" onclick="run()">Run</button>
  <button type="button" onclick="exportCsv()">Export CSV</button>
</form>

<pre id="out"></pre>

<script src="modules/SQLReport/resources/js/editor.js"></script>
