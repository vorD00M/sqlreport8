var ta = document.getElementById('queryTextarea');
var ed = CodeMirror.fromTextArea(ta,{
  mode:'text/x-sql',
  lineNumbers:true,
  matchBrackets:true
});

function run(){
 fetch('index.php?module=SQLReport&action=ExecuteQuery',{
  method:'POST',
  headers:{'Content-Type':'application/x-www-form-urlencoded'},
  body:'sql='+encodeURIComponent(ed.getValue())
 }).then(r=>r.json()).then(d=>{
  document.getElementById('out').textContent=JSON.stringify(d,null,2);
 });
}

function exportCsv(){
  window.location.href='index.php?module=SQLReport&action=ExecuteQuery&mode=export_csv&sql='+encodeURIComponent(ed.getValue());
}
