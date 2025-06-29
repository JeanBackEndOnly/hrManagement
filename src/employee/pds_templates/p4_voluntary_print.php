<table class="table table-bordered border-dark tbl-compact">
  <thead class="table-secondary fw-semibold">
    <tr>
      <th style="width:32%">Organization / Address</th>
      <th style="width:18%">Inclusive Dates<br>From‑To</th>
      <th style="width:10%">No. Hours</th>
      <th style="width:40%">Position / Nature of Work</th>
    </tr>
  </thead>
  <tbody>
    <?php $rows = max(count($pds['voluntary']??[]), 4);
    for($i=0;$i<$rows;$i++): ?>
    <tr>
      <td><?=arr('voluntary',$i,'org')?></td>
      <td><?=arr('voluntary',$i,'dates')?></td>
      <td><?=arr('voluntary',$i,'hours')?></td>
      <td><?=arr('voluntary',$i,'position')?></td>
    </tr>
    <?php endfor; ?>
  </tbody>
</table>
