<!-- PAGE 4 FORM – LEARNING & DEVELOPMENT -->
<?php $rows = max(count($pds['ld']??[]),4); ?>
<div class="table-responsive">
  <table class="table table-bordered tbl-compact">
    <thead class="table-secondary">
      <tr>
        <th>Title of L&D / Training</th><th style="width:14%">Inclusive Dates<br>From‑To</th>
        <th style="width:8%">Hours</th><th style="width:23%">Type of L&D</th>
        <th>Conducted / Sponsored by</th>
      </tr>
    </thead>
    <tbody>
      <?php for($i=0;$i<$rows;$i++): ?>
      <tr>
        <td><input type="text" class="form-control" name="ld[<?=$i?>][title]" value="<?=arr('ld',$i,'title')?>"></td>
        <td><input type="text" class="form-control" name="ld[<?=$i?>][dates]" value="<?=arr('ld',$i,'dates')?>"></td>
        <td><input type="text" class="form-control" name="ld[<?=$i?>][hours]" value="<?=arr('ld',$i,'hours')?>"></td>
        <td><input type="text" class="form-control" name="ld[<?=$i?>][type]" value="<?=arr('ld',$i,'type')?>"></td>
        <td><input type="text" class="form-control" name="ld[<?=$i?>][sponsor]" value="<?=arr('ld',$i,'sponsor')?>"></td>
      </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</div>
