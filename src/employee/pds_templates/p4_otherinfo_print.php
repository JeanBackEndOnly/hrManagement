<table class="table table-bordered border-dark tbl-compact">
  <thead class="table-secondary fw-semibold"><tr><th>Other Information</th><th>Details</th></tr></thead>
  <tbody>
    <?php
      $other = $pds['other'] ?? [];
      $rows  = max(count($other), 4);
      for($i=0;$i<$rows;$i++):
    ?>
      <tr><td><?=arr('other',$i,'label')?></td><td><?=arr('other',$i,'value')?></td></tr>
    <?php endfor; ?>
  </tbody>
</table>
