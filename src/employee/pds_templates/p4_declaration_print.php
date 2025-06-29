<!-- ---------- REFERENCES (at least 3) ---------- -->
<table class="table table-bordered border-dark tbl-compact mb-2">
  <thead class="table-secondary fw-semibold"><tr><th colspan="4">X. REFERENCES ( NOT RELATIVES / SUPERVISORS )</th></tr></thead>
  <tbody>
    <tr class="table-secondary small"><th style="width:32%">Name</th><th style="width:32%">Address</th><th style="width:20%">Tel No.</th><th style="width:16%">Occupation</th></tr>
    <?php $rows=max(count($pds['ref']??[]),3);for($i=0;$i<$rows;$i++):?>
    <tr>
      <td><?=arr('ref',$i,'name')?></td>
      <td><?=arr('ref',$i,'address')?></td>
      <td><?=arr('ref',$i,'tel')?></td>
      <td><?=arr('ref',$i,'work')?></td>
    </tr>
    <?php endfor; ?>
  </tbody>
</table>

<!-- ---------- GOVERNMENT‑ISSUED ID ---------- -->
<table class="table table-bordered border-dark tbl-compact mb-3">
  <thead class="table-secondary fw-semibold"><tr><th colspan="4">GOVERNMENT ISSUED ID</th></tr></thead>
  <tbody>
    <tr><th style="width:25%">ID/License/Passport No.</th><td><?=val('gov_id_no')?></td>
        <th style="width:25%">Date/Place of Issuance</th><td><?=val('gov_id_date')?></td></tr>
  </tbody>
</table>

<!-- ---------- QUESTIONS 34‑40 ---------- -->
<?php for($q=34;$q<=40;$q++): ?>
  <p class="mb-1"><strong><?=$q?>.</strong> <?=val('q'.$q.'_text','[Question '.$q.' text]')?>&nbsp;
    <u><?=val('q'.$q) ?: '__________'?></u>
  </p>
<?php endfor; ?>

<!-- ---------- DECLARATION & SIGNATURE ---------- -->
<p class="mt-3">I declare under oath that all information herein is true and correct...
<br><br>
Signature: ______________________________ Date: <?=val('decl_date')?>
</p>
