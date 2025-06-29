<!-- PAGE 4 FORM – REFERENCES, GOVT ID & DECLARATION -->
<h6 class="fw-bold">References ( Not Relatives / Supervisors )</h6>
<?php $refRows = max(count($pds['ref']??[]),3); ?>
<div class="table-responsive">
  <table class="table table-bordered tbl-compact">
    <thead class="table-secondary small">
      <tr><th>Name</th><th>Address</th><th style="width:20%">Tel No.</th><th style="width:18%">Occupation</th></tr>
    </thead>
    <tbody>
      <?php for($i=0;$i<$refRows;$i++): ?>
      <tr>
        <td><input type="text" class="form-control" name="ref[<?=$i?>][name]" value="<?=arr('ref',$i,'name')?>"></td>
        <td><input type="text" class="form-control" name="ref[<?=$i?>][address]" value="<?=arr('ref',$i,'address')?>"></td>
        <td><input type="text" class="form-control" name="ref[<?=$i?>][tel]" value="<?=arr('ref',$i,'tel')?>"></td>
        <td><input type="text" class="form-control" name="ref[<?=$i?>][work]" value="<?=arr('ref',$i,'work')?>"></td>
      </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</div>

<h6 class="fw-bold mt-3">Government‑Issued ID</h6>
<div class="row g-2">
  <div class="col-md-6"><label>ID / License / Passport No.</label>
    <input type="text" class="form-control" name="gov_id_no" value="<?=val('gov_id_no')?>">
  </div>
  <div class="col-md-6"><label>Date & Place of Issuance</label>
    <input type="text" class="form-control" name="gov_id_date" value="<?=val('gov_id_date')?>">
  </div>
</div>

<h6 class="fw-bold mt-4">Questions 34 – 40 (Answer Yes / No and provide details if Yes)</h6>
<?php for($q=34;$q<=40;$q++): ?>
  <div class="mb-2">
    <label class="form-label small fw-semibold">Q<?=$q?>. <?=val('q'.$q.'_text','[Question text]')?></label>
    <div class="input-group">
      <select class="form-select" style="max-width:80px" name="q<?=$q?>">
        <option value="" <?=val('q'.$q)==''?'selected':''?>>--</option>
        <option <?=val('q'.$q)=='Yes'?'selected':''?>>Yes</option>
        <option <?=val('q'.$q)=='No'?'selected':''?>>No</option>
      </select>
      <input type="text" class="form-control" name="q<?=$q?>_details" placeholder="If Yes, give details" value="<?=val('q'.$q.'_details')?>">
    </div>
  </div>
<?php endfor; ?>

<h6 class="fw-bold mt-4">Declaration</h6>
<div class="mb-3">
  <textarea class="form-control" rows="3" name="declaration_text"><?=val('declaration_text','I declare under oath that all information herein is true and correct...')?></textarea>
</div>
<div class="row g-2">
  <div class="col-md-6"><label>Signature (over printed name)</label>
    <input type="text" class="form-control" name="signature" value="<?=val('signature')?>">
  </div>
  <div class="col-md-6"><label>Date</label>
    <input type="date" class="form-control" name="decl_date" value="<?=val('decl_date')?>">
  </div>
</div>
