<!-- PAGE 1 FORM – PERSONAL INFORMATION -->
<div class="row g-2 mt-1">
  <div class="col-md-4"><label>Surname</label>
    <input type="text" class="form-control" name="surname" value="<?=val('surname')?>" required>
  </div>
  <div class="col-md-4"><label>First Name</label>
    <input type="text" class="form-control" name="firstname" value="<?=val('firstname')?>" required>
  </div>
  <div class="col-md-4"><label>Middle Name</label>
    <input type="text" class="form-control" name="middlename" value="<?=val('middlename')?>">
  </div>
</div>

<div class="row g-2 mt-1">
  <div class="col-md-3"><label>Name Extension</label>
    <input type="text" class="form-control" name="name_ext" value="<?=val('name_ext')?>">
  </div>
  <div class="col-md-3"><label>Date of Birth</label>
    <input type="date" class="form-control" name="birthdate" value="<?=val('birthdate')?>" required>
  </div>
  <div class="col-md-6"><label>Place of Birth</label>
    <input type="text" class="form-control" name="birthplace" value="<?=val('birthplace')?>" required>
  </div>
</div>

<div class="row g-2 mt-1">
  <div class="col-md-2"><label>Sex</label>
    <select name="sex" class="form-select" required>
      <option value="" disabled <?=val('sex')?'':'selected'?>>--</option>
      <option <?=val('sex')==='Male'?'selected':''?>>Male</option>
      <option <?=val('sex')==='Female'?'selected':''?>>Female</option>
    </select>
  </div>
  <div class="col-md-3"><label>Civil Status</label>
    <select name="civil_status" class="form-select" required>
      <?php foreach (['Single','Married','Widowed','Separated','Other'] as $opt): ?>
        <option <?=val('civil_status')===$opt?'selected':''?>><?=$opt?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-2"><label>Height (m)</label>
    <input type="text" class="form-control" name="height" value="<?=val('height')?>">
  </div>
  <div class="col-md-2"><label>Weight (kg)</label>
    <input type="text" class="form-control" name="weight" value="<?=val('weight')?>">
  </div>
  <div class="col-md-3"><label>Blood Type</label>
    <input type="text" class="form-control" name="blood_type" value="<?=val('blood_type')?>">
  </div>
</div>

<div class="row g-2 mt-1">
  <div class="col-md-2"><label>GSIS ID</label><input type="text" class="form-control" name="gsis" value="<?=val('gsis')?>"></div>
  <div class="col-md-2"><label>PAG‑IBIG No.</label><input type="text" class="form-control" name="pagibig" value="<?=val('pagibig')?>"></div>
  <div class="col-md-2"><label>PHILHEALTH No.</label><input type="text" class="form-control" name="philhealth" value="<?=val('philhealth')?>"></div>
  <div class="col-md-2"><label>SSS No.</label><input type="text" class="form-control" name="sss" value="<?=val('sss')?>"></div>
  <div class="col-md-2"><label>TIN</label><input type="text" class="form-control" name="tin" value="<?=val('tin')?>"></div>
  <div class="col-md-2"><label>Agency Emp. No.</label><input type="text" class="form-control" name="agency_no" value="<?=val('agency_no')?>"></div>
</div>

<div class="row g-2 mt-1">
  <div class="col-md-4"><label>Citizenship</label>
    <input type="text" class="form-control" name="citizenship" value="<?=val('citizenship')?>">
  </div>
  <div class="col-md-4"><label>Residential Address</label>
    <input type="text" class="form-control" name="res_address" value="<?=val('res_address')?>">
  </div>
  <div class="col-md-4"><label>Permanent Address</label>
    <input type="text" class="form-control" name="perm_address" value="<?=val('perm_address')?>">
  </div>
</div>

<div class="row g-2 mt-1">
  <div class="col-md-4"><label>Email Address</label>
    <input type="email" class="form-control" name="email" value="<?=val('email')?>">
  </div>
  <div class="col-md-4"><label>Cellphone No.</label>
    <input type="text" class="form-control" name="cellphone" value="<?=val('cellphone')?>">
  </div>
  <div class="col-md-4"><label>Telephone No.</label>
    <input type="text" class="form-control" name="tel" value="<?=val('tel')?>">
  </div>
</div>
