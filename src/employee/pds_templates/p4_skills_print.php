<ul class="mb-2">
  <?php
    $skills = $pds['skills'] ?? [];
    $max = max(count($skills), 5);
    for($i=0;$i<$max;$i++):
      $item = $skills[$i] ?? '&nbsp;';
  ?>
    <li><?=$item?></li>
  <?php endfor; ?>
</ul>
