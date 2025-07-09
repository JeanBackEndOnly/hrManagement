<?php
if (!function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime(): bool { return false; }
    function set_magic_quotes_runtime($new): bool { return false; }
}

require __DIR__ . '/../../vendor/autoload.php';
require_once '../../installer/config.php';
// require_once '../../templates/pendingHeader.php';
 function getPersonalData(): array
    {
        $pdo      = db_connection();
            $users_id = (int)($_GET['pending_user_id'] ?? 0);
        
        if (!$users_id) {
            return [];
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "
            SELECT u.*,
                ui.*,                 -- userInformations
                uhr.*,                -- userHr_Informations
                pds.pds_id
            FROM   users                 AS u
            JOIN   userInformations      AS ui  ON u.id = ui.users_id
            JOIN   userHr_Informations   AS uhr ON u.id = uhr.users_id
            JOIN   personal_data_sheet   AS pds ON u.id = pds.users_id
            WHERE  u.id = :id
            LIMIT  1
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $users_id]);
        $core = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$core) {                       
            return [];
        }

        $pds_id = (int)$core['pds_id'];

        $data = ['user' => $core];

        $oneToOneQueries = [
            'userGovIDs' => "SELECT * FROM userGovIDs  WHERE pds_id = :pid LIMIT 1",
            'spouseInfo' => "SELECT * FROM spouseInfo  WHERE pds_id = :pid LIMIT 1",
            'otherInfo'  => "SELECT * FROM otherInfo   WHERE pds_id = :pid LIMIT 1",
        ];

        foreach ($oneToOneQueries as $key => $sql) {
            $st = $pdo->prepare($sql);
            $st->execute([':pid' => $pds_id]);
            $data[$key] = $st->fetch(PDO::FETCH_ASSOC) ?: [];
        }

        $oneToManyQueries = [
            'children' => "SELECT * FROM children
                        WHERE pds_id = :pid
                        ORDER BY id",

            'parents'  => "SELECT * FROM parents
                        WHERE pds_id = :pid
                        ORDER BY FIELD(relation,'Father','Mother')",

            'siblings' => "SELECT * FROM siblings
                        WHERE pds_id = :pid
                        ORDER BY birth_order",

            'educationInfo' => "SELECT * FROM educationInfo
                                WHERE pds_id = :pid
                                ORDER BY FIELD(level,
                                    'Elementary','Secondary','Vocational',
                                    'College','Graduate')",

            'workExperience' => "SELECT * FROM workExperience
                                WHERE pds_id = :pid
                                ORDER BY id",

            'seminarsTrainings' => "SELECT * FROM seminarsTrainings
                                    WHERE pds_id = :pid
                                    ORDER BY id",
        ];

        foreach ($oneToManyQueries as $key => $sql) {
            $st = $pdo->prepare($sql);
            $st->execute([':pid' => $pds_id]);
            $data[$key] = $st->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }
$pdo       = db_connection();
$users_id  = (int)($_GET['users_id'] ?? 0);
$pds_id    = (int)($_GET['pds_id']   ?? 0);
if (!$users_id || !$pds_id) { exit('Missing users_id or pds_id'); }

$data = getPersonalData();               
$u    = $data['user']     ?? [];
$gov  = $data['userGovIDs'] ?? [];
$oth  = $data['otherInfo']  ?? [];

function v($a, $k, $d=''){ return $a[$k] ?? $d; }
function h($s){ return htmlspecialchars_decode($s); }

$pdf = new \FPDF('P', 'mm', 'A4');
$pdf->SetMargins(15,15,15);
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('Arial','',9);

$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,7,'PERSONAL DATA SHEET',0,1,'C');
$pdf->Ln(2);
$pdf->SetFont('Arial','',9);

$pdf->Cell(0,6,'PERSONAL INFORMATION',1,1,'C');
$pdf->Cell(50,6,'Full name',1); $pdf->Cell(140,6,h(v($u,'lname').', '.v($u,'fname').' '.v($u,'mname')),1,1);
$pdf->Cell(50,6,'Date of birth',1); $pdf->Cell(140,6,v($u,'birth_date'),1,1);
$pdf->Cell(50,6,'Place of birth',1); $pdf->Cell(140,6,v($u,'birth_place'),1,1);
$pdf->Cell(50,6,'Civil status',1); $pdf->Cell(140,6,v($u,'civil_status'),1,1);
$pdf->Cell(50,6,'Sex',1); $pdf->Cell(140,6,v($u,'sex'),1,1);
$pdf->Cell(50,6,'Citizenship',1); $pdf->Cell(140,6,v($u,'citizenship'),1,1);
$pdf->Cell(50,6,'Height (cm)',1); $pdf->Cell(140,6,v($oth,'height'),1,1);
$pdf->Cell(50,6,'Weight (kg)',1); $pdf->Cell(140,6,v($oth,'weight'),1,1);
$pdf->Cell(50,6,'Blood type',1); $pdf->Cell(140,6,v($oth,'blood_type'),1,1);
$pdf->Cell(50,6,'Present address',1); $pdf->Cell(140,6,v($u,'present_address'),1,1);
$pdf->Cell(50,6,'Permanent address',1); $pdf->Cell(140,6,v($u,'permanent_address'),1,1);
$pdf->Cell(50,6,'Telephone no.',1); $pdf->Cell(140,6,v($u,'telephone'),1,1);
$pdf->Cell(50,6,'Mobile no.',1); $pdf->Cell(140,6,v($u,'mobile'),1,1);
$pdf->Cell(50,6,'Email address',1); $pdf->Cell(140,6,v($u,'email'),1,1);

/* --- government IDs --- */
$pdf->Ln(2);
$pdf->Cell(0,6,'GOVERNMENT IDENTIFICATION NUMBERS',1,1,'C');
$pdf->Cell(50,6,'GSIS ID No.',1); $pdf->Cell(140,6,v($gov,'gsis'),1,1);
$pdf->Cell(50,6,'Pag-IBIG ID No.',1); $pdf->Cell(140,6,v($gov,'pagibig'),1,1);
$pdf->Cell(50,6,'PhilHealth No.',1); $pdf->Cell(140,6,v($gov,'philhealth'),1,1);
$pdf->Cell(50,6,'SSS No.',1); $pdf->Cell(140,6,v($gov,'sss'),1,1);
$pdf->Cell(50,6,'TIN',1); $pdf->Cell(140,6,v($gov,'tin'),1,1);
$pdf->Cell(50,6,'Agency employee No.',1); $pdf->Cell(140,6,v($gov,'agency_id'),1,1);

/* --- family background --- */
$pdf->Ln(2);
$pdf->Cell(0,6,'FAMILY BACKGROUND',1,1,'C');

// Spouse section
$pdf->Cell(0,6,'SPOUSE',1,1);
$pdf->Cell(50,6,'First name',1); $pdf->Cell(140,6,'',1,1);
$pdf->Cell(50,6,'Middle name',1); $pdf->Cell(140,6,'',1,1);
$pdf->Cell(50,6,'Last name',1); $pdf->Cell(140,6,'',1,1);
$pdf->Cell(50,6,'Occupation',1); $pdf->Cell(140,6,'',1,1);
$pdf->Cell(50,6,'Employer/Business name',1); $pdf->Cell(140,6,'',1,1);
$pdf->Cell(50,6,'Business address',1); $pdf->Cell(140,6,'',1,1);
$pdf->Cell(50,6,'Telephone no.',1); $pdf->Cell(140,6,'',1,1);

// Parents section
$pdf->Ln(2);
$pdf->Cell(0,6,'FATHER',1,1);
$pdf->Cell(50,6,'First name',1); $pdf->Cell(140,6,'',1,1);
$pdf->Cell(50,6,'Middle name',1); $pdf->Cell(140,6,'',1,1);
$pdf->Cell(50,6,'Last name',1); $pdf->Cell(140,6,'',1,1);

$pdf->Ln(2);
$pdf->Cell(0,6,'MOTHER',1,1);
$pdf->Cell(50,6,'First name',1); $pdf->Cell(140,6,'',1,1);
$pdf->Cell(50,6,'Middle name',1); $pdf->Cell(140,6,'',1,1);
$pdf->Cell(50,6,'Maiden last name',1); $pdf->Cell(140,6,'',1,1);

// Children section
$pdf->Ln(2);
$pdf->Cell(0,6,'CHILDREN (List all)',1,1,'C');
$w = [70,20,50,50]; // name, age, occupation, address
$pdf->Cell($w[0],6,'NAME',1,0,'C');
$pdf->Cell($w[1],6,'AGE',1,0,'C');
$pdf->Cell($w[2],6,'OCCUPATION',1,0,'C');
$pdf->Cell($w[3],6,'ADDRESS',1,1,'C');
for($i=0;$i<4;$i++){
    foreach($w as $cw) $pdf->Cell($cw,6,'',1);
    $pdf->Ln();
}

/* --- educational background --- */
$pdf->Ln(2);
$pdf->Cell(0,6,'EDUCATIONAL BACKGROUND',1,1,'C');
$w2=[30,50,40,50,20];
$hdr=['LEVEL','NAME OF SCHOOL','DEGREE/COURSE','SCHOOL ADDRESS','YEAR'];
foreach($hdr as $i=>$txt) $pdf->Cell($w2[$i],6,$txt,1,0,'C');
$pdf->Ln();
foreach(['ELEMENTARY','SECONDARY','VOCATIONAL','COLLEGE','GRADUATE'] as $lvl){
    $pdf->Cell($w2[0],6,$lvl,1);
    for($i=1;$i<5;$i++) $pdf->Cell($w2[$i],6,'',1);
    $pdf->Ln();
}

/*-----------------------------------------------------------------
 * page 2
 *----------------------------------------------------------------*/
$pdf->AddPage();

/* headline */
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,7,'PERSONAL DATA SHEET',0,1,'C');
$pdf->Ln(2);
$pdf->SetFont('Arial','',9);

/* work experience */
$pdf->Cell(0,6,'WORK EXPERIENCE',1,1,'C');
$ww=[40,40,70,40];
$hdr=['DATES (mm/yyyy)','POSITION TITLE','DEPARTMENT/AGENCY/COMPANY','SALARY'];
foreach($hdr as $i=>$h) $pdf->Cell($ww[$i],6,$h,1,0,'C');
$pdf->Ln();
for($i=0;$i<5;$i++){ 
    foreach($ww as $cw) $pdf->Cell($cw,6,'',1); 
    $pdf->Ln(); 
}

/* seminars */
$pdf->Ln(2);
$pdf->Cell(0,6,'SEMINARS / WORKSHOPS / TRAININGS ATTENDED',1,1,'C');
$sw=[40,90,60];
$sh=['DATES','TITLE OF SEMINAR/TRAINING','PLACE'];
foreach($sh as $i=>$t) $pdf->Cell($sw[$i],6,$t,1,0,'C'); $pdf->Ln();
for($i=0;$i<5;$i++){ foreach($sw as $cw) $pdf->Cell($cw,6,'',1); $pdf->Ln(); }

/* others block */
$pdf->Ln(2);
$pdf->Cell(0,6,'OTHERS',1,1,'C');
$pdf->MultiCell(0,6,'What are your special skills/hobbies?',1);
$pdf->Cell(0,6,h(v($oth,'special_skills')),1,1);

$pdf->Cell(0,6,'Do you own/rent the house you live in?',1,1);
$own = ($oth['house_status']??'')==='owned'?'☑':'☐';
$rent = ($oth['house_status']??'')==='rented'?'☑':'☐';
$pdf->Cell(50,6,"Owned $own",1); 
$pdf->Cell(50,6,"Rented $rent",1);
$pdf->Cell(90,6,'If rented, amount of rental per month: PHP '.v($oth,'rental_amount'),1,1);

$pdf->Cell(0,6,'Type of House:',1,1);
$light = ($oth['house_type']??'')==='light'?'☑':'☐';
$semi = ($oth['house_type']??'')==='semi_concrete'?'☑':'☐';
$con = ($oth['house_type']??'')==='concrete'?'☑':'☐';
$pdf->Cell(60,6,"Light materials $light",1);
$pdf->Cell(65,6,"Semi-concrete $semi",1);
$pdf->Cell(65,6,"Concrete $con",1,1);

$pdf->MultiCell(0,6,'Who stays with you at home? [State number of persons and relationship to employer.]',1);
$pdf->Cell(0,6,h(v($oth,'household_members')),1,1);

$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$dec = "I declare under oath that this Personal Data Sheet has been accomplished by me, and is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines. I also authorize the head/authorized representatives to verify/validate the contents stated herein. I trust that this information shall remain confidential.";
$pdf->MultiCell(0,4,$dec,1);

$pdf->Ln(2);
$boxH=20;
$pdf->Cell(80,$boxH,'',1,0,'C'); 
$pdf->Cell(40,$boxH,'',1,0,'C'); 
$pdf->Cell(40,$boxH,'',1,0,'C'); 
$pdf->Cell(30,$boxH,'',1,1,'C'); 

$pdf->Cell(80,5,'Signature (Sign inside the box)',0,0,'C');
$pdf->Cell(40,5,'Right Thumbmark',0,0,'C');
$pdf->Cell(40,5,'Left Thumbmark',0,0,'C');
$pdf->Cell(30,5,'PHOTO',0,1,'C');

$pdf->Cell(80,5,'Date accomplished: '.date('m/d/Y'),0,1);

/* output */
$filename="pds-{$users_id}.pdf";
$pdf->Output('I',$filename);
exit;