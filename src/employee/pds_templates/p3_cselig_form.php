<!-- PAGE 3 FORM – CIVIL SERVICE ELIGIBILITY -->
<?php $rows = max(count($pds['elig']??[]),4); ?>
<div class="table-responsive">
  <table class="table table-bordered tbl-compact">
    <thead class="table-secondary">
      <tr>
        <th>Career Service / RA 1080</th><th style="width:8%">Rating</th>
        <th>Date of Exam</th><th>Place of Exam</th>
        <th>License No.</th><th>Date of Validity</th>
      </tr>
    </thead>
    <tbody>
      <?php for($i=0;$i<$rows;$i++): ?>
      <tr>
        <td><input type="text" class="form-control" name="elig[<?=$i?>][type]" value="<?=arr('elig',$i,'type')?>"></td>
        <td><input type="text" class="form-control" name="elig[<?=$i?>][rating]" value="<?=arr('elig',$i,'rating')?>"></td>
        <td><input type="date" class="form-control" name="elig[<?=$i?>][date]" value="<?=arr('elig',$i,'date')?>"></td>
        <td><input type="text" class="form-control" name="elig[<?=$i?>][place]" value="<?=arr('elig',$i,'place')?>"></td>
        <td><input type="text" class="form-control" name="elig[<?=$i?>][license]" value="<?=arr('elig',$i,'license')?>"></td>
        <td><input type="date" class="form-control" name="elig[<?=$i?>][validity]" value="<?=arr('elig',$i,'validity')?>"></td>
      </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</div>
