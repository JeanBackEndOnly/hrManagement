<!-- PAGE 4 FORM – SPECIAL SKILLS / DISTINCTIONS -->
<?php $skills = $pds['skills'] ?? []; $max = max(count($skills),5); ?>
<ul class="list-unstyled">
  <?php for($i=0;$i<$max;$i++): ?>
    <li class="mb-1">
      <input type="text" class="form-control" name="skills[<?=$i?>]" value="<?=htmlspecialchars($skills[$i] ?? '')?>">
    </li>
  <?php endfor; ?>
</ul>
