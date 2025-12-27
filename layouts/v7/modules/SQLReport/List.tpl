<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="page-header">
        <h3 style="display:inline-block;margin-right:15px;">Сохранённые SQL отчёты</h3>
        <div class="btn-group">
          <a href="index.php?module=SQLReport&view=Edit" class="btn btn-primary"><i class="fa fa-plus"></i> Новый запрос</a>
        </div>
      </div>
    </div>
  </div>
  {if $QUERIES && count($QUERIES) > 0}
    <div class="table-responsive" style="margin-top:15px;">
      <table class="table table-bordered table-striped table-sm listViewEntriesTable">
        <thead>
          <tr>
            <th style="width: 220px;">Название</th>
            <th>SQL</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$QUERIES item=Q}
            <tr>
              <td>{$Q.name|escape}</td>
              <td><pre style="margin:0; white-space:pre-wrap;">{$Q.sql_query|escape}</pre></td>
            </tr>
          {/foreach}
        </tbody>
      </table>
    </div>
  {else}
    <div class="alert alert-info" style="margin-top:15px;">Нет сохранённых запросов.</div>
  {/if}
</div>
