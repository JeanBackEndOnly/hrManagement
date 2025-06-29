<!-- PAGE 2 FORM – FAMILY BACKGROUND -->
<h6 class="mt-2 fw-bold">A. Immediate Family</h6>
<div class="row g-2">
  <div class="col-md-4"><label>Spouse Surname</label>
    <input type="text" class="form-control" name="spouse_surname" value="<?=val('spouse_surname')?>">
  </div>
  <div class="col-md-4"><label>First Name</label>
    <input type="text" class="form-control" name="spouse_first" value="<?=val('spouse_first')?>">
  </div>
  <div class="col-md-4"><label>Middle Name</label>
    <input type="text" class="form-control" name="spouse_middle" value="<?=val('spouse_middle')?>">
  </div>
</div>
<div class="row g-2 mt-1">
  <div class="col-md-3"><label>Occupation</label>
    <input type="text" class="form-control" name="spouse_occ" value="<?=val('spouse_occ')?>">
  </div>
  <div class="col-md-3"><label>Employer / Business Name</label>
    <input type="text" class="form-control" name="spouse_emp" value="<?=val('spouse_emp')?>">
  </div>
  <div class="col-md-4"><label>Business Address</label>
    <input type="text" class="form-control" name="spouse_addr" value="<?=val('spouse_addr')?>">
  </div>
  <div class="col-md-2"><label>Telephone No.</label>
    <input type="text" class="form-control" name="spouse_tel" value="<?=val('spouse_tel')?>">
  </div>
</div>

<h6 class="mt-3 fw-bold">B. Parents</h6>
<div class="row g-2">
  <div class="col-md-4"><label>Father Surname</label>
    <input type="text" class="form-control" name="father_surname" value="<?=val('father_surname')?>">
  </div>
  <div class="col-md-4"><label>First Name</label>
    <input type="text" class="form-control" name="father_first" value="<?=val('father_first')?>">
  </div>
  <div class="col-md-4"><label>Middle Name</label>
    <input type="text" class="form-control" name="father_middle" value="<?=val('father_middle')?>">
  </div>
</div>
<div class="row g-2 mt-1">
  <div class="col-md-4"><label>Mother Maiden Name</label>
    <input type="text" class="form-control" name="mother_maiden" value="<?=val('mother_maiden')?>">
  </div>
  <div class="col-md-4"><label>First Name</label>
    <input type="text" class="form-control" name="mother_first" value="<?=val('mother_first')?>">
  </div>
  <div class="col-md-4"><label>Middle Name</label>
    <input type="text" class="form-control" name="mother_middle" value="<?=val('mother_middle')?>">
  </div>
</div>

<h6 class="mt-3 fw-bold">C. Children (list eldest first)</h6>
<?php $max = max(count($pds['children']??[]),6); ?>
<div class="table-responsive">
  <table class="table table-bordered tbl-compact">
    <thead><tr><th style="width:70%">Full Name</th><th>Date of Birth</th></tr></thead>
    <tbody>
      <?php for($i=0;$i<$max;$i++): ?>
        <tr>
          <td><input type="text" class="form-control" name="children[<?=$i?>][name]" value="<?=arr('children',$i,'name')?>"></td>
          <td><input type="date" class="form-control" name="children[<?=$i?>][dob]" value="<?=arr('children',$i,'dob')?>"></td>
        </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</div>
