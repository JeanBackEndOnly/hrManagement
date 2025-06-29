<!-- PAGE 4 FORM – OTHER INFORMATION -->
<?php $other = $pds['other'] ?? []; $rows = max(count($other),4); ?>
<div class="table-responsive">
  <table class="table table-bordered tbl-compact">
    <thead class="table-secondary">
      <tr><th>Other Information</th><th>Details</th></tr>
    </thead>
    <tbody>
      <?php for($i=0;$i<$rows;$i++): ?>
      <tr>
        <td><input type="text" class="form-control" name="other[<?=$i?>][label]" value="<?=arr('other',$i,'label')?>"></td>
        <td><input type="text" class="form-control" name="other[<?=$i?>][value]" value="<?=arr('other',$i,'value')?>"></td>
      </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</div>
