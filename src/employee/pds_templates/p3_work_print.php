<table class="table table-bordered border-dark tbl-compact">
  <thead class="table-secondary fw-semibold">
    <tr>
      <th style="width:12%">Inclusive Dates<br>From‑To</th>
      <th style="width:28%">Position Title</th>
      <th style="width:22%">Department / Agency<br>& Address</th>
      <th style="width:8%">Salary<br>(₱)</th>
      <th style="width:8%">SG&nbsp;/&nbsp;Step</th>
      <th style="width:10%">Status of<br>Appointment</th>
      <th style="width:12%">Gov't Service<br>(Y/N)</th>
    </tr>
  </thead>
  <tbody>
    <?php $rows = max(count($pds['work']??[]), 8);
    for($i=0;$i<$rows;$i++): ?>
      <tr>
        <td><?=arr('work',$i,'dates')?></td>
        <td><?=arr('work',$i,'position')?></td>
        <td><?=arr('work',$i,'office')?></td>
        <td><?=arr('work',$i,'salary')?></td>
        <td><?=arr('work',$i,'sg')?></td>
        <td><?=arr('work',$i,'status')?></td>
        <td><?=arr('work',$i,'govt')?></td>
      </tr>
    <?php endfor; ?>
  </tbody>
</table>
