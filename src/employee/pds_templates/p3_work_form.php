<!-- PAGE 3 FORM – WORK EXPERIENCE -->
<?php $rows = max(count($pds['work']??[]),8); ?>
<div class="table-responsive">
  <table class="table table-bordered tbl-compact">
    <thead class="table-secondary">
      <tr>
        <th>Inclusive Dates<br>From‑To</th><th>Position Title</th>
        <th>Dept / Agency & Address</th><th style="width:8%">Salary</th>
        <th style="width:6%">SG/Stp</th><th>Status</th><th style="width:6%">Gov't (Y/N)</th>
      </tr>
    </thead>
    <tbody>
      <?php for($i=0;$i<$rows;$i++): ?>
      <tr>
        <td><input type="text" class="form-control" name="work[<?=$i?>][dates]" value="<?=arr('work',$i,'dates')?>"></td>
        <td><input type="text" class="form-control" name="work[<?=$i?>][position]" value="<?=arr('work',$i,'position')?>"></td>
        <td><input type="text" class="form-control" name="work[<?=$i?>][office]" value="<?=arr('work',$i,'office')?>"></td>
        <td><input type="text" class="form-control" name="work[<?=$i?>][salary]" value="<?=arr('work',$i,'salary')?>"></td>
        <td><input type="text" class="form-control" name="work[<?=$i?>][sg]" value="<?=arr('work',$i,'sg')?>"></td>
        <td><input type="text" class="form-control" name="work[<?=$i?>][status]" value="<?=arr('work',$i,'status')?>"></td>
        <td>
          <select class="form-select" name="work[<?=$i?>][govt]">
            <option value="" <?=arr('work',$i,'govt')==''?'selected':''?>>--</option>
            <option <?=arr('work',$i,'govt')=='Yes'?'selected':''?>>Yes</option>
            <option <?=arr('work',$i,'govt')=='No'?'selected':''?>>No</option>
          </select>
        </td>
      </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</div>
