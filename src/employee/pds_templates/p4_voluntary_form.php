<!-- PAGE 4 FORM – VOLUNTARY WORK -->
<?php $rows = max(count($pds['voluntary']??[]),4); ?>
<div class="table-responsive">
  <table class="table table-bordered tbl-compact">
    <thead class="table-secondary">
      <tr>
        <th>Organization / Address</th><th style="width:18%">Inclusive Dates<br>From‑To</th>
        <th style="width:10%">Hours</th><th>Position / Nature of Work</th>
      </tr>
    </thead>
    <tbody>
      <?php for($i=0;$i<$rows;$i++): ?>
      <tr>
        <td><input type="text" class="form-control" name="voluntary[<?=$i?>][org]" value="<?=arr('voluntary',$i,'org')?>"></td>
        <td><input type="text" class="form-control" name="voluntary[<?=$i?>][dates]" value="<?=arr('voluntary',$i,'dates')?>"></td>
        <td><input type="text" class="form-control" name="voluntary[<?=$i?>][hours]" value="<?=arr('voluntary',$i,'hours')?>"></td>
        <td><input type="text" class="form-control" name="voluntary[<?=$i?>][position]" value="<?=arr('voluntary',$i,'position')?>"></td>
      </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</div>
