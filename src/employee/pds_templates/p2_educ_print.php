<?php
$levels = [
  'elementary' => 'ELEMENTARY', 'secondary' => 'SECONDARY',
  'vocational' => 'VOCATIONAL / TRADE / COURSE',
  'college'    => 'COLLEGE',    'graduate'  => 'GRADUATE STUDIES'
];
?>
<table class="table table-bordered border-dark tbl-compact">
  <thead class="table-secondary fw-semibold">
    <tr>
      <th rowspan="2" style="width:18%">LEVEL</th>
      <th rowspan="2" style="width:32%">NAME OF SCHOOL</th>
      <th rowspan="2" style="width:15%">DEGREE / COURSE</th>
      <th colspan="2">PERIOD OF ATTENDANCE</th>
      <th rowspan="2" style="width:8%">UNITS EARNED</th>
      <th rowspan="2" style="width:8%">YEAR GRADUATED</th>
      <th rowspan="2" style="width:15%">ACADEMIC HONORS</th>
    </tr>
    <tr><th style="width:7%">From</th><th style="width:7%">To</th></tr>
  </thead>
  <tbody>
    <?php foreach($levels as $code=>$label): ?>
      <tr>
        <td><?=$label?></td>
        <td><?=val($code.'_school')?></td>
        <td><?=val($code.'_course')?></td>
        <td><?=val($code.'_from')?></td>
        <td><?=val($code.'_to')?></td>
        <td><?=val($code.'_units')?></td>
        <td><?=val($code.'_gradyear')?></td>
        <td><?=val($code.'_honors')?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
