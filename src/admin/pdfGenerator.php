<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once '../../installer/config.php';
$pdo = db_connection();
if (!function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime(): bool { return false; }
}

$users_id = $_GET['users_id'] ?? 'unknown';
$query = "SELECT * FROM users
INNER JOIN leavereq ON users.id = leavereq.users_id
INNER JOIN leave_details ON leavereq.leave_id = leave_details.leaveID
WHERE users.id = :id;";
$statement = $pdo->prepare($query);
$statement->bindParam(":id", $users_id);
$statement->execute();
$leave = $statement->fetch(PDO::FETCH_ASSOC);

$query = "SELECT * FROM users
INNER JOIN userinformations ON users.id = userinformations.users_id
INNER JOIN userhr_informations ON users.id = userhr_informations.users_id
WHERE users.id = :id;";
$statement = $pdo->prepare($query);
$statement->bindParam(":id", $users_id);
$statement->execute();
$employee = $statement->fetch(PDO::FETCH_ASSOC);

$pdf = new \FPDF('P', 'mm', 'A4');
$pdf->SetMargins(10, 10);       
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 6, 'ZAMBOANGA PUERICULTURE CENTER ORG. NO. 144 INC.', 0, 1, 'C');


$pdf->SetFont('Arial', 'BU', 12);
$pdf->Cell(0, 7, 'APPLICATION FOR LEAVE', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(4);
$pdf->Cell(20, 6, 'NAME:', 0, 0);

$wLast  = 40;
$wFirst = 40;
$wMI    = 18;
$middleInitial = $employee['mname'];
$mi = substr($middleInitial, 0, 1);
$pdf->Cell($wLast, 6, $employee['lname'] ?? '',  'B', 0);  
$pdf->Cell(1, 6, '', 0, 0);                               

$pdf->Cell($wFirst, 6, $employee['fname'] ?? '', 'B', 0);
$pdf->Cell(1, 6, '', 0, 0);

$pdf->Cell($wMI, 6, $mi . "." ?? '',     'B', 0);

$pdf->Cell(5, 6, '', 0, 0);

$pdf->Cell(30, 6, 'DATE OF FILING:', 0, 0);
$pdf->Cell(35, 6, $leave['leaveDate'] ?? '', 'B', 1);     

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 4, '', 0, 0);       
$pdf->Cell($wLast, 4,  'Last Name', 0, 0);
$pdf->Cell(1,   4, '', 0, 0);
$pdf->Cell($wFirst, 4, 'First Name', 0, 0);
$pdf->Cell(1,   4, '', 0, 0);
$pdf->Cell($wMI, 4,   'M.I.',       0, 1);
$pdf->Ln(4);                      


$pdf->Cell(20, 6, 'POSITION:', 0, 0);
$pdf->Cell(60, 6, $employee['jobTitle'] ?? '', 'B', 0);
$pdf->Cell(8, 6, '', 0, 0);
$pdf->Cell(42, 6, 'DEPARTMENT/SECTION:', 0, 0);
$pdf->Cell(0, 6, $employee['department'] . " DEPARTMENT" ?? '', 'B', 1);
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(38, 6, 'LEAVE APPLIED FOR :', 0, 0);
$box = function ($label) use ($pdf) {
    $pdf->Cell(4, 4, '', 1, 0);       
    $pdf->Cell(2, 4, '', 0, 0);
    $pdf->Cell(32, 4, $label, 0, 0);
};
$box('Vacation Leave');
$box('Sick Leave');
$pdf->Ln(6);
$pdf->Cell(38, 6, '', 0, 0);        
$box('Special Leave');
$box('Other (specify) ______');
$pdf->Ln(8);

/* ------------ Cause / Purpose line --------------------------------- */
$pdf->Cell(28, 6, 'CAUSE/PURPOSE :', 0, 0);
$pdf->Cell(0, 6, '', 'B', 1);
$pdf->Ln(4);

/* ------------ Inclusive dates & No of days ------------------------- */
$pdf->Cell(28, 6, 'INCLUSIVE DATES :', 0, 0);
$pdf->Cell(80, 6, '', 'B', 0);
$pdf->Cell(22, 6, 'NO. OF DAYS :', 0, 0);
$pdf->Cell(0, 6, '', 'B', 1);
$pdf->Ln(4);

/* ------------ Contact number --------------------------------------- */
$pdf->Cell(55, 6, 'CONTACT NO. WHILE ON LEAVE :', 0, 0);
$pdf->Cell(0, 6, '', 'B', 1);
$pdf->Ln(4);

/* ------------ Pledge paragraph ------------------------------------- */
$pdf->SetFont('Arial', '', 9);
$pledge = "I hereby pledge to report for work immediately the following day after "
        . "expiration of my approved leave of absence unless otherwise duly extended.  "
        . "My failure to do so shall subject me to disciplinary action.";
$pdf->MultiCell(0, 4.5, $pledge);
$pdf->Ln(6);

/* ------------ Recommending Approval & Signature -------------------- */
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 6, 'Recommending Approval:', 0, 0);
$pdf->Cell(60, 6, '', 'B', 0);
$pdf->Cell(10, 6, '', 0, 0);
$pdf->Cell(0, 6, 'Signature of Applicant', 0, 1, 'R');
$ySig = $pdf->GetY();
$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(130, $ySig, 200, $ySig);      // underline for applicant signature
$pdf->Ln(8);

/* ====================================================================
   DETAILS OF ACTION ON APPLICATION (bordered table)
==================================================================== */
$startX = 10;
$startY = $pdf->GetY();
$tableW = 190;
$rowH   = 7;

/* Outer rectangle */
$pdf->Rect($startX, $startY, $tableW, $rowH * 7); // 5 data rows + 2 header rows

/* ---- Internal horizontal lines ---- */
for ($i = 1; $i <= 6; $i++) {
    $pdf->Line($startX, $startY + $rowH * $i,
               $startX + $tableW, $startY + $rowH * $i);
}

/* ---- Internal vertical lines ---- */
$col1 = 55;  $col2 = 45;  $col3 = 45;  $col4 = 45;      // widths
$xPos = $startX + $col1;
$pdf->Line($xPos, $startY, $xPos, $startY + $rowH * 7);
$xPos += $col2;
$pdf->Line($xPos, $startY, $xPos, $startY + $rowH * 7);
$xPos += $col3;
$pdf->Line($xPos, $startY, $xPos, $startY + $rowH * 7);

/* ---- Header text -------------------------------------------------- */
$pdf->SetXY($startX, $startY);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell($col1, $rowH, 'DETAILS OF ACTION ON APPLICATION', 1, 0, 'C');
$pdf->Cell($col2 + $col3 + $col4, $rowH, '', 1, 1);    // empty filler

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell($col1, $rowH, '', 1, 0);                    // left empty (label col)
$pdf->Cell($col2, $rowH, 'VACATION', 1, 0, 'C');
$pdf->Cell($col3, $rowH, 'SICK',      1, 0, 'C');
$pdf->Cell($col4, $rowH, 'SPECIAL',   1, 1, 'C');

/* ---- Row labels --------------------------------------------------- */
$pdf->SetFont('Arial', '', 8);
$rows = [
    'Balance as of:',
    'Leave Earned',
    'Total Leave Credits as of',
    'Less this Leave',
    'Balance to Date',
];
foreach ($rows as $label) {
    $pdf->Cell($col1, $rowH, $label, 1, 0);
    $pdf->Cell($col2, $rowH, '', 1, 0);
    $pdf->Cell($col3, $rowH, '', 1, 0);
    $pdf->Cell($col4, $rowH, '', 1, 1);
}

/* ---- Recommendation box inside table ------------------------------ */
$recY = $startY + $rowH * 6;                    // 6th horizontal line
$pdf->SetXY($startX + $col1, $recY);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($col2 + $col3 + $col4, $rowH, 'Recommendation for:    (  ) Approval     (  ) Disapproval due to: ________', 1, 1);

/* ---- Signatures below table --------------------------------------- */
$pdf->Ln(6);
$signW = 60;
$pdf->Cell($signW, 6, 'Section Head', 0, 0, 'C');
$pdf->Cell($signW, 6, 'Department Head', 0, 0, 'C');
$pdf->Cell($signW, 6, 'HRDO', 0, 0, 'C');
$pdf->Cell($signW, 6, 'Administrator', 0, 1, 'C');

/* Draw signature lines */
$y = $pdf->GetY() - 4;
for ($i = 0; $i < 4; $i++) {
    $x1 = 10 + $i * $signW;
    $x2 = $x1 + ($signW - 2);
    $pdf->Line($x1 + 2, $y, $x2, $y);
}

/* ------------------------------------------------------------------
   Output
------------------------------------------------------------------- */
$filename = "leave-report-{$users_id}.pdf";
$pdf->Output('I', $filename);
