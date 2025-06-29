<table class="table table-bordered border-dark tbl-compact">
  <thead class="table-secondary fw-semibold">
    <tr>
      <th style="width:29%">CAREER SERVICE / RA 1080</th>
      <th style="width:8%">RATING</th>
      <th style="width:12%">DATE OF EXAM</th>
      <th style="width:15%">PLACE OF EXAM</th>
      <th style="width:12%">LICENSE No.</th>
      <th style="width:12%">DATE OF VALIDITY</th>
    </tr>
  </thead>
  <tbody>
    <?php $rows = max(count($pds['elig']??[]), 4);
    for($i=0;$i<$rows;$i++): ?>
      <tr>
        <td><?=arr('elig',$i,'type')?></td>
        <td><?=arr('elig',$i,'rating')?></td>
        <td><?=arr('elig',$i,'date')?></td>
        <td><?=arr('elig',$i,'place')?></td>
        <td><?=arr('elig',$i,'license')?></td>
        <td><?=arr('elig',$i,'validity')?></td>
      </tr>
    <?php endfor; ?>
  </tbody>
</table>
