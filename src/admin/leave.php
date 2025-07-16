<?php
 include '../../templates/Uheader.php';
 include '../../templates/HN.php';
?>
<?php if (isset($_GET['open_pdf']) && $_GET['open_pdf'] == '1') : ?>
<script>
    window.onload = function () {
        window.open('pdfGenerator.php?users_id=<?php echo $_GET["users_id"]; ?>&leave_id=<?php echo $_GET["leave_id"]; ?>', '_blank');
    };
</script>
<?php endif;  ?>
<main>
    <div class="main-body w-100 h-100 m-0 p-0">
        <?php echo renderHeader() ?>
        
        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <?php renderNav() ?>

            <?php
                $leaveStatus   = $_GET['leave_tab']  ?? 'pending';   
                $leavePage     = max(1, (int)($_GET['leave_page'] ?? 1));
                $leavePerPage  = max(1, (int)($_GET['leave_perPage'] ?? 10));
                $sortColumn    = $_GET['leave_sort']  ?? 'request_date';
                $sortOrder     = $_GET['leave_order'] ?? 'desc';

                $offset        = ($leavePage - 1) * $leavePerPage;

                $leaveData     = leaves_fetch(
                    $leaveStatus,
                    $leavePerPage,
                    $offset,
                    $sortColumn,
                    $sortOrder
                );

                $leaveTotal    = leaves_count($leaveStatus);
                $leaveTotalPages = max(1, (int)ceil($leaveTotal / $leavePerPage));

                function buildQuery(array $add): string
                {
                    $qs = $_GET;
                    unset($qs['leave_id']);                
                    $qs = array_merge($qs, $add);
                    return http_build_query($qs);
                }

                $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
            ?>

            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">

                <div class="header-employee d-flex flex-wrap col-md-12 flex-row justify-content-between align-items-center"
                    style="height: 7rem; width: 95%;">
                    <div class="h1 flex-row col-md-5 col-12 align-items-center justify-content-start " style="display:flex;">
                        <h3 class="m-0">LEAVE REQUESTS</h3>
                    </div>

                    <div class="leaveTabButtons  d-flex flex-row col-md-5 col-12 align-items-center justify-content-between">
                        <?php
                        $tabs = ['pending' => 'REQUEST', 'approved' => 'APPROVED', 'disapprove' => 'DISAPPROVED'];
                        foreach ($tabs as $key => $label): ?>
                            <div class="crud-employee d-flex flex-row col-md-4 col-12 align-items-center justify-content-end"
                                style="width: 32%; height: 2rem">
                                <a href="<?= $currentUrl ?>?leave_tab=<?= $key ?>&leave_page=1&leave_perPage=<?= $leavePerPage ?>"
                                    class="tab-btns w-100 needs-loader d-flex justify-content-center <?= $leaveTab === $key ? 'active' : '' ?>" style="text-decoration: none;">
                                    <?= $label ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="search-leave flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2"
                    style="width: 95%; display:flex;">
                    <div class="search-bar d-flex align-items-center justify-content-start"
                        style="width: 80%; transform: translateX(-10px);">
                        <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                            <input type="text" class="form-control ps-5" placeholder="Search..."
                                id="leaveSearchInput"
                                value="<?= htmlspecialchars($_GET['leave_q'] ?? '') ?>">
                            <i class="fa-solid fa-magnifying-glass position-absolute"
                            style="top:50%; left:15px; transform:translateY(-50%); color:gray;"></i>
                        </div>
                    </div>

                    <div class="count" style="width:8%;">
                        <select class="form-select"
                                onchange="location.href='<?= $currentUrl ?>?leave_tab=<?= $leaveTab ?>&leave_perPage='+this.value">
                            <option disabled>Items</option>
                            <?php foreach ([10,20,50] as $opt): ?>
                                <option value="<?= $opt ?>" <?= $leavePerPage == $opt ? 'selected':'' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="sort" style="width:8%;">
                        <select class="form-select"
                                onchange="location.href='<?= $currentUrl ?>?leave_tab=<?= $leaveTab ?>&leave_sort=request_date&leave_order='+this.value">
                            <option disabled selected>Sort</option>
                            <option value="asc"  <?= $leaveSortOrder==='asc'  ? 'selected':'' ?>>Oldest</option>
                            <option value="desc" <?= $leaveSortOrder==='desc' ? 'selected':'' ?>>Recent</option>
                        </select>
                    </div>
                </div>

                <div class="leave-list " style="width:95%; margin:10px auto; height:50vh; display:flex; flex-direction:column;">
                    <table class="table table-bordered table-striped mt-3"
                        style="width:100%; border-collapse:separate; flex:1 1 auto; display:block;">
                        <thead style="display:table-header-group; width:100%; background:white; position:sticky; top:0; z-index:10;">
                            <tr style="display:table; width:100%; table-layout:fixed;">
                                <th style="width:5%;">#</th>
                                <th style="width:25%;">Employee</th>
                                <th style="width:25%;">Leave Type</th>
                                <th style="width:20%;">From-To</th>
                                <th style="width:15%;">Status</th>
                                <th style="width:10%;">Actions</th>
                            </tr>
                        </thead>

                        <tbody style="display:block; overflow-y:auto; height:calc(50vh - 50px); width:99.8%; margin-left:2px;">
                            <?php if ($leaveData): ?>
                                <?php $no = ($leavePage - 1) * $leavePerPage + 1; ?>
                                <?php foreach ($leaveData as $row): ?>
                                    <tr data-row="leave" style="display:table; width:100%; table-layout:fixed;">
                                        <td style="width:5%;"><?= $no ?></td>
                                        <td style="width:25%;"><?= htmlspecialchars($row['lname'] . ', ' . $row['fname']) ?></td>
                                        <td style="width:25%;"><?= htmlspecialchars($row['leaveType']) ?></td>
                                        <td style="width:20%;">
                                            <?= date('M j',  strtotime($row['InclusiveFrom'])) ?>
                                            - <?= date('M j, Y', strtotime($row['InclusiveTo'])) ?>
                                        </td>
                                        <td style="width:15%;">
                                            <?php
                                            echo match ($row['leaveStatus']) {
                                                'approved'    => '<span class="text-success">Approved</span>',
                                                'disapprove' => '<span class="text-danger">Disapproved</span>',
                                                default       => 'Pending'
                                            };
                                            ?>
                                        </td>
                                        <?php
                                        switch($row["leaveStatus"]) {
                                            case "pending":
                                                echo '<td style="width:10%;">';
                                                    echo '<a class="btn btn-sm btn-primary"
                                                    href="employeeLeaveReq.php?users_id=' . $row['users_id'] . '&leave_id=' . $row['leave_id'] . '">
                                                        View
                                                    </a>';

                                                    echo '<button type="button"
                                                            class="btn btn-sm btn-danger ms-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal' . $row['leave_id']. '">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>';
                                                echo '</td>';

                                                break;
                                            case "approved":
                                                echo '<td style="width:10%;">';
                                                    echo '<a class="btn btn-sm btn-primary"
                                                    href="leave.php?users_id=' . $row['users_id'] . '&leave_id=' . $row['leave_id'] . '&open_pdf=1&leave_tab={$tab}">
                                                        View
                                                    </a>';
                                                     echo '<button type="button"
                                                            class="btn btn-sm btn-danger ms-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModalApp' . $row['leave_id']. '">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>';
                                                echo '</td>';
                                                break;
                                            case "disapprove":
                                                    echo '<td style="width:10%;">';
                                                    echo '<a class="btn btn-sm btn-primary"
                                                    href="leave.php?users_id=' . $row['users_id'] . '&leave_id=' . $row['leave_id'] . '&open_pdf=1&leave_tab={$tab}">
                                                        View
                                                    </a>';
                                                     echo '<button type="button"
                                                            class="btn btn-sm btn-danger ms-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModalDis' . $row['leave_id']. '">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>';
                                                echo '</td>';
                                                break;
                                            default:
                                                echo 'No leaveStatus match!';
                                            break;
                                        }
                                        ?>

                                    </tr>

                                    <!-- ==================== ADDED: matching modal inside loop ==================== -->
                                    <?php
                                        // choose the correct ID that your button points to
                                        if ($row["leaveStatus"] === "pending") {
                                            $modalId = "deleteModal" . $row['leave_id'];
                                        } elseif ($row["leaveStatus"] === "approved") {
                                            $modalId = "deleteModalApp" . $row['leave_id'];
                                        } else {
                                            $modalId = "deleteModalDis" . $row['leave_id'];
                                        }
                                    ?>
                                    <div class="modal fade"
                                        id="<?= $modalId ?>"
                                        tabindex="-1"
                                        aria-labelledby="<?= $modalId ?>Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="../../auth/authentications.php" method="POST">
                                                    <?php $csrf = $_SESSION["csrf_token"] ?? ""; ?>
                                                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                                    <input type="hidden" name="deleteLeave" value="true">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="<?= $modalId ?>Label">Confirm delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                    Are you sure you want to permanently remove this leave request for
                                                    <strong><?= htmlspecialchars($row['lname'] . ', ' . $row['fname']) ?></strong>
                                                    (<?= date('M j, Y', strtotime($row['InclusiveFrom'])) ?> - <?= date('M j, Y', strtotime($row['InclusiveTo'])) ?>)?
                                                    <input type="hidden" name="action"   value="delete_leave">
                                                    <input type="hidden" name="leave_id" value="<?= $row['leave_id'] ?>">
                                                    <input type="hidden" name="users_id" value="<?= $row['users_id'] ?>">
                                                    </div>

                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- =========================================================================== -->

                                    <?php $no++; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr style="display:table; width:100%; table-layout:fixed;">
                                    <td colspan="6" class="text-center">No leaves found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-between align-items-center mt-1" style="flex-shrink:0;">
                        <div>Page <?= $leavePage ?> of <?= $leaveTotalPages ?></div>
                        <div>
                            <a href="<?= $currentUrl ?>?leave_tab=<?= $leaveTab ?>&leave_page=<?= max(1,$leavePage-1) ?>&leave_perPage=<?= $leavePerPage ?>"
                            class="btn btn-sm btn-outline-primary <?= $leavePage<=1?'disabled':'' ?>">Previous</a>
                            <a href="<?= $currentUrl ?>?leave_tab=<?= $leaveTab ?>&leave_page=<?= min($leaveTotalPages,$leavePage+1) ?>&leave_perPage=<?= $leavePerPage ?>"
                            class="btn btn-sm btn-outline-primary <?= $leavePage>=$leaveTotalPages?'disabled':'' ?>">Next</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>
<div id="loadingAnimation" style="display:none;">
  <div class="loading-lines">
    <div class="line"></div>
    <div class="line"></div>
    <div class="line"></div>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.needs-loader').forEach(el =>
            el.addEventListener('click', showLoader, { passive:true })
        );
    });
    document.addEventListener('DOMContentLoaded', () => {
        const tab = new URLSearchParams(location.search).get('leave_tab');
        if (!tab) return;

        document
            .querySelectorAll('a[href*="leave_id="], a[href*="employeeLeaveReq.php"]')
            .forEach(link => {
            const url = new URL(link.href, location.origin);
            url.searchParams.set('leave_tab', tab);
            link.href = url.pathname + '?' + url.searchParams.toString();
            });

        document
            .querySelectorAll('form[action*="authentications.php"]')
            .forEach(f => {
            if (!f.querySelector('input[name="leave_tab"]')) {
                const hidden = document.createElement('input');
                hidden.type  = 'hidden';
                hidden.name  = 'leave_tab';
                hidden.value = tab;
                f.appendChild(hidden);
            }
            });
    });
    function showLoadingAndRun(callback){
        showLoader();               
        setTimeout(()=>{
            document.getElementById("loadingAnimation").style.display="none";
            callback();
        }, 500);
    }
    function showLoader(){ document.getElementById("loadingAnimation").style.display="flex"; }

    window.addEventListener("pageshow", ()=> {
        const loader = document.getElementById("loadingAnimation");
        if (loader) loader.style.display = "none";
    });
document.addEventListener('DOMContentLoaded', () => {

  const searchInput = document.getElementById('leaveSearchInput');
  const tbody       = document.querySelector('.leave-list tbody');
  if (!searchInput || !tbody) return;

  const rows = Array.from(tbody.querySelectorAll('tr[data-row="leave"]'));
  rows.forEach(r => {           
    r._origDisplay = r.style.display || 'table';
    r._cacheText   = r.textContent.toLowerCase();  
  });

  searchInput.addEventListener('keyup', () => {
    const kw = searchInput.value.trim().toLowerCase();
    rows.forEach(row => {
      row.style.display = row._cacheText.includes(kw) ? row._origDisplay : 'none';
    });
  });
});
</script>

<?php include '../../templates/Ufooter.php'?>
