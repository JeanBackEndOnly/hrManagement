<?php
ob_start();   
require __DIR__ . '/../../vendor/autoload.php';
require_once '../../installer/config.php';
$pdo = db_connection();
if (!function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime(): bool { return false; }
}

$leaveStmt = $pdo->prepare("
    SELECT * FROM leavereq
    INNER JOIN users          ON leavereq.users_id = users.id
    INNER JOIN leave_details  ON leavereq.leave_id = leave_details.leaveID
    WHERE leavereq.leave_id = :leave_id
");
$leaveStmt->execute([':leave_id' => $_GET['leave_id'] ?? 0]);
$leave = $leaveStmt->fetch(PDO::FETCH_ASSOC) ?: [];     

$empStmt = $pdo->prepare("
    SELECT * FROM users
    INNER JOIN userinformations    ON users.id = userinformations.users_id
    INNER JOIN userhr_informations ON users.id = userhr_informations.users_id
    WHERE users.id = :id
");
$empStmt->execute([':id' => $_GET['users_id'] ?? 0]);
$employee = $empStmt->fetch(PDO::FETCH_ASSOC) ?: [];    

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
$pdf->Cell(40, 6, 'LEAVE APPLIED FOR :', 0, 0);

$box = function ($label, $selected = false) use ($pdf) {
    $mark = $selected ? '/' : '';
    $pdf->SetFont('Arial', '', 8);                
    $pdf->Cell(4, 4, $mark, 1, 0, 'C');
    $pdf->SetFont('Arial', '', 10);              
    $pdf->Cell(2, 4, '', 0, 0);
    $pdf->Cell(32, 4, $label, 0, 0);
};

$leaveType = $leave["leaveType"] ?? '';

$box('Vacation Leave',  $leaveType === 'vacation');
$box('Sick Leave',      $leaveType === 'sick');                           
$box('Special Leave',  $leaveType === 'special');

$pdf->Ln(6); 
$pdf->Cell(40, 6, '', 0, 0); 
$box('Other (specify)', !empty($leave['Others']));

if (!empty($leave['Others'])) {
    $pdf->Cell(38, 6, $leave['Others'], 0, 0);
}

$pdf->Ln(8);                            

$pdf->Cell(35, 6, 'CAUSE/PURPOSE :', 0, 0);
$pdf->Cell(0, 6, $leave['Purpose'] ?? '', 'B', 1);
$pdf->Ln(4);

$pdf->Cell(35, 6, 'INCLUSIVE DATES :', 0, 0);
// one‑liner, just add parentheses
$pdf->Cell(
    80,
    6,
    ($leave['InclusiveFrom'] ?? '') . ' to ' . ($leave['InclusiveTo'] ?? 'wala'),
    'B',
    0
);

$pdf->Cell(27, 6, 'NO. OF DAYS :', 0, 0);
$pdf->Cell(0, 6, $leave["numberOfDays"], 'B', 1);
$pdf->Ln(4);

$pdf->Cell(60, 6, 'CONTACT NO. WHILE ON LEAVE :', 0, 0);
$pdf->Cell(0, 6, $leave["contact"] ?? '', 'B', 1);
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 9);
$pledge = "I hereby pledge to report for work immediately the following day after "
        . "expiration of my approved leave of absence unless otherwise duly extended.  "
        . "My failure to do so shall subject me to disciplinary action.";
$pdf->MultiCell(0, 4.5, $pledge);
$pdf->Ln(6);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 6, 'Recommending Approval:', 0, 0);
$pdf->Ln(2);
$pdf->Cell(10, 6, '', 0, 0);
$ySig = $pdf->GetY();
$pdf->Cell(165, 6, 'Signature of Applicant', 0, 1, 'R');
$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(130, $ySig, 200, $ySig);   
$pdf->Ln(6);

$sigWidth = 50;
$ySig = $pdf->GetY();          

$xLeft = 11;                
$pdf->Line($xLeft, $ySig, $xLeft + $sigWidth, $ySig);    

$pdf->SetXY($xLeft, $ySig - 4);
$pdf->Cell($sigWidth, 4, $leave['sectionHead'] ?? '', 0, 0, 'C');

$pdf->SetXY($xLeft, $ySig + 2);
$pdf->Cell($sigWidth, 4, 'Section Head', 0, 0, 'C');

$xRight = 70;              
$pdf->Line($xRight, $ySig, $xRight + $sigWidth, $ySig);  

$pdf->SetXY($xRight, $ySig - 4);
$pdf->Cell($sigWidth, 4, $leave['departmentHead'] ?? '', 0, 0, 'C');

$pdf->SetXY($xRight, $ySig + 2);
$pdf->Cell($sigWidth, 4, 'Department Head', 0, 0, 'C');

$pdf->Ln(10);
            
$rowH   = 7;                  
$mainX  = 10;                  
$mainY  = $pdf->GetY();        
$mainW  = 190;                
$leftW  = 110;                 
$rightW = $mainW - $leftW;      

$mainH = $rowH * (1 + 6 + 2); 

$pdf->Rect($mainX, $mainY, $mainW, $mainH);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetXY($mainX, $mainY);
$pdf->Cell($mainW, $rowH, 'DETAILS OF ACTION ON APPLICATION', 1, 1, 'C');

$subY = $mainY + $rowH;                    
$pdf->Line($mainX + $leftW, $subY, $mainX + $leftW, $mainY + $mainH);

$tblX = $mainX;
$tblY = $subY;

$colLbl = 44;
$colVac = ($leftW - $colLbl) / 3;  

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY($tblX, $tblY);
$pdf->Cell($colLbl, $rowH, '', 1, 0);
$pdf->Cell($colVac, $rowH, 'VACATION', 1, 0, 'C');
$pdf->Cell($colVac, $rowH, 'SICK',      1, 0, 'C');
$pdf->Cell($colVac, $rowH, 'SPECIAL',   1, 1, 'C');

$pdf->SetFont('Arial', '', 8);
$labels = [
    'Balance as of:',
    'Leave Earned',
    'Total Leave Credits as of',
    'Less this Leave',
    'Balance to Date'
];

$leaveType = strtolower(trim($leave['leaveType'] ?? ''));

$col = function (string $columnName, string $field) use ($leave, $leaveType) {
    return $leaveType === $columnName ? ($leave[$field] ?? '') : '';
};

$rows = [
    [
        'label'   => 'Balance as of:',
        'vac'     => $col('vacation', 'balance'),
        'sick'    => $col('sick',     'balance'),
        'special' => $col('special',  'balance'),
    ],
    [
        'label'   => 'Leave Earned',
        'vac'     => $col('vacation', 'earned'),
        'sick'    => $col('sick',     'earned'),
        'special' => $col('special',  'earned'),
    ],
    [
        'label'   => 'Total Leave Credits as of',
        'vac'     => $col('vacation', 'credits'),
        'sick'    => $col('sick',     'credits'),
        'special' => $col('special',  'credits'),
    ],
    [
        'label'   => 'Less this Leave',
        'vac'     => $col('vacation', 'lessLeave'),
        'sick'    => $col('sick',     'lessLeave'),
        'special' => $col('special',  'lessLeave'),
    ],
    [
        'label'   => 'Balance to Date',
        'vac'     => $col('vacation', 'balanceToDate'),
        'sick'    => $col('sick',     'balanceToDate'),
        'special' => $col('special',  'balanceToDate'),
    ],
];

$pdf->SetFont('Arial', '', 8);

foreach ($rows as $r) {
    $pdf->SetX($tblX);                               
    $pdf->Cell($colLbl, $rowH, $r['label'], 1, 0);   
    $pdf->Cell($colVac, $rowH, $r['vac'],     1, 0, 'C');
    $pdf->Cell($colVac, $rowH, $r['sick'],    1, 0, 'C');
    $pdf->Cell($colVac, $rowH, $r['special'], 1, 1, 'C');
}

$recX = $mainX + $leftW;    
$recY = $subY;              
$recW = $rightW;            
$recH = $rowH * 6;            

$pdf->Line($recX,             $recY,              $recX + $recW, $recY);       
$pdf->Line($recX,             $recY,              $recX,         $recY + $recH);
$pdf->Line($recX + $recW,     $recY,              $recX + $recW, $recY + $recH); 

/* -------- Recommendation text with dynamic tick ---------------- */
$status  = strtolower($leave['leaveStatus'] ?? '');
$reason  = $leave['disapprovalDetails'] ?? '';

if ($status === 'approved') {
    $recText  = "Recommendation for:\n";
    $recText .= "   (/) Approval\n";
    $recText .= "   ( ) Disapproval due to: __________________";
} elseif ($status === 'disapprove') {
    $recText  = "Recommendation for:\n";
    $recText .= "   ( ) Approval\n";
    $recText .= "   (/) Disapproval due to: {$reason}";
} else {                         // no decision yet
    $recText  = "Recommendation for:\n";
    $recText .= "   ( ) Approval\n";
    $recText .= "   ( ) Disapproval due to: __________________";
}

$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($recX + 2, $recY + 2);
$pdf->MultiCell($recW - 4, 4, $recText);

$sigY   = $subY + $recH + 7;    
$sigWid = 60;                  

$adminX = $mainX + ($leftW - $sigWid) / 2;
$pdf->Line($adminX, $sigY, $adminX + $sigWid, $sigY);
$pdf->SetXY($adminX, $sigY + 2);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($sigWid, 1, 'HRDO', 0, 0, 'C');

$hrdoX = $recX + ($rightW - $sigWid) / 2;
$pdf->Line($hrdoX, $sigY, $hrdoX + $sigWid, $sigY);
$pdf->SetXY($hrdoX, $sigY + 2);
$pdf->Cell($sigWid, 1, 'Administrator', 0, 1, 'C');

$pdf->SetY($mainY + $mainH + 2);

ob_end_clean();               
$filename = "leave-report-{$_GET['users_id']}.pdf";
$pdf->Output('I', $filename);