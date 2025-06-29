<!-- PAGE 2 FORM – EDUCATIONAL BACKGROUND -->
<?php
$levels = [
  'elementary' => 'Elementary',
  'secondary'  => 'Secondary',
  'vocational' => 'Vocational / Trade',
  'college'    => 'College',
  'graduate'   => 'Graduate Studies'
];
?>
<div class="table-responsive">
  <table class="table table-bordered tbl-compact">
    <thead class="table-secondary">
      <tr>
        <th>Level</th><th>Name of School</th><th>Degree / Course</th>
        <th style="width:6%">From</th><th style="width:6%">To</th>
        <th style="width:8%">Units<br>Earned</th><th style="width:8%">Year Grad</th>
        <th>Honors</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($levels as $code=>$label): ?>
      <tr>
        <td><?=$label?></td>
        <td><input type="text" class="form-control" name="<?=$code?>_school" value="<?=val($code.'_school')?>"></td>
        <td><input type="text" class="form-control" name="<?=$code?>_course" value="<?=val($code.'_course')?>"></td>
        <td><input type="text" class="form-control" name="<?=$code?>_from" value="<?=val($code.'_from')?>"></td>
        <td><input type="text" class="form-control" name="<?=$code?>_to" value="<?=val($code.'_to')?>"></td>
        <td><input type="text" class="form-control" name="<?=$code?>_units" value="<?=val($code.'_units')?>"></td>
        <td><input type="text" class="form-control" name="<?=$code?>_gradyear" value="<?=val($code.'_gradyear')?>"></td>
        <td><input type="text" class="form-control" name="<?=$code?>_honors" value="<?=val($code.'_honors')?>"></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
