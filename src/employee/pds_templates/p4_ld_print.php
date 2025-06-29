<table class="table table-bordered border-dark tbl-compact">
  <thead class="table-secondary fw-semibold">
    <tr>
      <th style="width:40%">Title of L&D Intervention / Training</th>
      <th style="width:14%">Inclusive Dates<br>From‑To</th>
      <th style="width:8%">Hours</th>
      <th style="width:23%">Type of L&D</th>
      <th style="width:15%">Conducted / Sponsored by</th>
    </tr>
  </thead>
  <tbody>
    <?php $rows = max(count($pds['ld']??[]), 4);
    for($i=0;$i<$rows;$i++): ?>
    <tr>
      <td><?=arr('ld',$i,'title')?></td>
      <td><?=arr('ld',$i,'dates')?></td>
      <td><?=arr('ld',$i,'hours')?></td>
      <td><?=arr('ld',$i,'type')?></td>
      <td><?=arr('ld',$i,'sponsor')?></td>
    </tr>
    <?php endfor; ?>
  </tbody>
</table>
