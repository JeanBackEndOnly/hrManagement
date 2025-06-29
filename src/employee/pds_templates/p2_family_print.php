<table class="table table-bordered border-dark tbl-compact mb-2">
  <tbody>
    <tr class="table-secondary fw-semibold"><td colspan="6">A. IMMEDIATE FAMILY</td></tr>
    <tr>
      <th style="width:20%">24. SPOUSE'S SURNAME</th><td><?=val('spouse_surname')?></td>
      <th style="width:20%">FIRST NAME</th><td><?=val('spouse_first')?></td>
      <th style="width:15%">MIDDLE NAME</th><td><?=val('spouse_middle')?></td>
    </tr>
    <tr>
      <th>OCCUPATION</th><td><?=val('spouse_occ')?></td>
      <th>EMPLOYER/BUSINESS NAME</th><td><?=val('spouse_emp')?></td>
      <th>BUSINESS ADDRESS</th><td><?=val('spouse_addr')?></td>
    </tr>
    <tr>
      <th>TELEPHONE No.</th><td><?=val('spouse_tel')?></td>
      <td colspan="4"></td>
    </tr>

    <tr class="table-secondary fw-semibold"><td colspan="6">B. PARENTS</td></tr>
    <tr><th>25. FATHER'S SURNAME</th><td><?=val('father_surname')?></td>
        <th>FIRST NAME</th><td><?=val('father_first')?></td>
        <th>MIDDLE NAME</th><td><?=val('father_middle')?></td></tr>
    <tr><th>26. MOTHER'S MAIDEN NAME</th><td><?=val('mother_maiden')?></td>
        <th>FIRST NAME</th><td><?=val('mother_first')?></td>
        <th>MIDDLE NAME</th><td><?=val('mother_middle')?></td></tr>
  </tbody>
</table>

<!-- ---------- CHILDREN LIST ---------- -->
<table class="table table-bordered border-dark tbl-compact">
  <thead>
    <tr class="table-secondary fw-semibold"><th colspan="2">27. CHILDREN (Write full names & birth dates – eldest first)</th></tr>
    <tr><th style="width:70%">Full Name</th><th>Date of Birth</th></tr>
  </thead>
  <tbody>
    <?php
      $max = max(count($pds['children']??[]), 6);   // show at least 6 blank rows
      for($i=0;$i<$max;$i++):
    ?>
      <tr>
        <td><?=arr('children',$i,'name')?></td>
        <td><?=arr('children',$i,'dob')?></td>
      </tr>
    <?php endfor; ?>
  </tbody>
</table>
