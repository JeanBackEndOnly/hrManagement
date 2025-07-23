<?php
 include '../../templates/Uheader.php';
 include '../../templates/HN.php';
?>
<style>
.hr {
      background: linear-gradient(40deg, #E53935, #e53835c2, #e538358f, #e538352f) !important;
    color: #fff !important;
}

.hrP,
.me-side-text1 {
    color: #fff !important;
    font-weight: bold !important;
}
</style>
<main>
    <div class="main-body w-100 h-100 m-0 p-0">
        <?php echo renderHeader() ?>

        <div class="d-flex w-100 align-items-start" style="height: 91%">
            
           <?php renderNav() ?>

            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee d-flex flex-wrap col-md-12 flex-row justify-content-between align-items-center" style="height: 7rem; width: 95%;">
                    <div class="h1 AnimationFinalfirst">
                        <h3 class="m-0 titleFont">HR MANAGEMENT</h3>
                        <p style="font-size: 17px !important; margin-top: -1rem !important;"><span>Promotions and Manage Job title</span></p>
                    </div>
                    <div class="jobSalaryButton d-flex flex-row col-md-5 col-12 align-items-center justify-content-between">
                        <div class="crud-employee d-flex flex-row col-md-5 col-12 align-items-center justify-content-end" style="width: 48%; height: 2rem">
                            <button type="button" class="tab-btns w-100" onclick="jobTitleButton()" style="font-size:15px; border:none; box-shadow: none;" id="jobTtitles">
                                JOB TITLES
                            </button>
                        </div>
                        <div class="crud-employee d-flex flex-row col-md-5 col-12 align-items-center justify-content-end" style="width: 48%; height: 2rem">
                            <button type="button" class="tab-btns w-100 " onclick="jobSalaryButton()" style="font-size:15px; border:none; box-shadow: none;" id="salaryManage">
                                PROMOTION
                            </button>
                        </div>
                    </div>
                </div>
                <div class="header-employee flex-row justify-content-end align-items-center m-0" style="height: 4rem; width: 95%; display: flex;" id="buttonJobTitle">
                    <div class="crud-employee d-flex flex-row align-items-center justify-content-end" style="width: 20rem; height: 2rem">
                      <button type="button" class="rounded-2 border-2" style="font-size:15px;" id="add" data-bs-toggle="modal" data-bs-target="#addJobModal">Add</button>
                    </div>
                </div>
                <div class="search-titles flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2" style="width: 95%; display: flex;" id="headerTableJob">
                    <div class="search-bar d-flex align-items-center justify-content-start" style="width: 80%; transform: translateX(-10px);">
                        <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                            <input type="text" class="form-control ps-5" placeholder="Search..." id="jobTitleSearchInput">
                            <i class="fa-solid fa-magnifying-glass position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: gray;"></i>
                        </div>
                    </div>
                    <div class="count" style="width: 8%;">
                        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?perPage=' + this.value + '&sort=<?= $jobSortColumn ?>&order=<?= $jobSortOrder ?>'">
                            <option disabled>Items</option>
                            <option value="10" <?= ($jobPerPage == 10) ? 'selected' : '' ?>>10</option>
                            <option value="20" <?= ($jobPerPage == 20) ? 'selected' : '' ?>>20</option>
                            <option value="50" <?= ($jobPerPage == 50) ? 'selected' : '' ?>>50</option>
                        </select>
                    </div>

                    <div class="sort" style="width: 8%;">
                        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?sort=jobTitle&order=' + this.value;">
                            <option selected disabled>Sort</option>
                            <option value="asc">A-Z</option>
                            <option value="desc">Z-A</option>
                            <option value="recent">Recent</option>
                        </select>
                    </div>
                </div>

                <!-- ==================== List of Job Titles ================================== -->
                <div class="job-list" style="width: 95%; margin: 10px auto; height: 50vh; display: flex; flex-direction: column;" id="jobList">
                    <table id="jobTitleTableBody" class="table table-bordered table-striped mt-3" style="width: 100%; border-collapse: separate; flex: 1 1 auto; display: block;">
                        <thead style="display: table-header-group; width: 100%; background: white; position: sticky; top: 0; z-index: 10; color: #000;">
                            <tr style="display: table; width: 100%; table-layout: fixed;">
                                <th style="width: 5%;">#</th>
                                <th style="width: 45%;">
                                    <a href="<?= $currentUrl ?>?sort=jobTitle&order=<?= ($jobSortColumn === 'jobTitle' && $jobSortOrder === 'asc') ? 'desc' : 'asc' ?>&perPage=<?= $jobPerPage ?>&page=1" style="color:black; text-decoration:none;">
                                        Job Title <?= $jobSortColumn === 'jobTitle' ? ($jobSortOrder === 'asc' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th style="width: 30%;">
                                    <a href="<?= $currentUrl ?>?sort=addAt&order=<?= ($jobSortColumn === 'addAt' && $jobSortOrder === 'asc') ? 'desc' : 'asc' ?>&perPage=<?= $jobPerPage ?>&page=1" style="color:black; text-decoration:none;">
                                        Added At <?= $jobSortColumn === 'addAt' ? ($jobSortOrder === 'asc' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th style="width: 20%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="display: block; overflow-y: auto; height: calc(50vh - 50px); width: 99.8%; margin-left: 2px;">
                            <?php if (!empty($jobTitles)): ?>
                                <?php
                                $num = $jobPage;
                                foreach ($jobTitles as $row): ?>
                                    <tr style="display: table; width: 100%; table-layout: fixed;">
                                        <td style="width: 5%;"><?= $num ?></td>
                                        <td style="width: 45%;"><?= htmlspecialchars($row['jobTitle']) ?></td>
                                        <td style="width: 30%;"><?= date('F j, Y h:i A', strtotime($row['addAt'])) ?></td>
                                        <td style="width: 20%;">
                                            <button class="btn btn-sm btn-primary me-2" onclick='editJob(<?= $row["id"] ?>, <?= json_encode($row["jobTitle"]) ?>)'>Edit</button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteJobModal" onclick="setDeleteJobId(<?= $row['id'] ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                $num++;
                                endforeach;
                                ?>
                            <?php else: ?>
                                <tr style="display: table; width: 100%; table-layout: fixed;">
                                    <td colspan="4" class="text-center">No job titles found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-1" style="flex-shrink: 0;">
                        <div>
                            Page <?= $jobPage ?> of <?= $jobTotalPages ?>
                        </div>
                        <div>
                            <a href="<?= $currentUrl ?>?page=<?= max(1, $jobPage - 1) ?>&perPage=<?= $jobPerPage ?>&sort=<?= $jobSortColumn ?>&order=<?= $jobSortOrder ?>" class="btn btn-sm btn-outline-primary <?= ($jobPage <= 1) ? 'disabled' : '' ?>">Previous</a>
                            <a href="<?= $currentUrl ?>?page=<?= min($jobTotalPages, $jobPage + 1) ?>&perPage=<?= $jobPerPage ?>&sort=<?= $jobSortColumn ?>&order=<?= $jobSortOrder ?>" class="btn btn-sm btn-outline-primary <?= ($jobPage >= $jobTotalPages) ? 'disabled' : '' ?>">Next</a>
                        </div>
                    </div>
                </div>

                <!-- ==================== Add Modal ==================== -->
                <div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addJobModalLabel">Add Job Title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addJobForm" action="../../auth/authentications.php" method="post">
                                    <input type="hidden" name="addJob" value="true">
                                    <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                    <div class="mb-3">
                                        <label for="jobTitle" class="form-label">Job Title</label>
                                        <input type="text" class="form-control" id="jobTitle" name="jobTitle" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" form="addJobForm" class="btn btn-primary">Add Job</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== Edit Job Title ================================== -->
                <div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="../../auth/authentications.php" class="modal-content">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                            <input type="hidden" name="EditJobTitle" value="true">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editJobModalLabel">Edit Job Title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="editJobId" id="editJobId">
                            <div class="mb-3">
                            <label for="editJobTitle" class="form-label">Job Title</label>
                            <input type="text" class="form-control" id="editJobTitle" name="editJobTitle" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="updateJob" class="btn btn-primary">Save Changes</button>
                        </div>
                        </form>
                    </div>
                </div>

                <!-- ==================== Delete Job Title Modal ==================== -->
                <div class="modal fade" id="deleteJobModal" tabindex="-1" aria-labelledby="deleteJobModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="../../auth/authentications.php" class="modal-content">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                            <input type="hidden" name="deleteJobTitle" value="true">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title" id="deleteJobModalLabel" style="color: #fff;">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this job title?
                                <input type="hidden" name="deleteJob" id="deleteJobId">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- ======================================= SALARY ===================================== -->
                <?php $currentUrl = strtok($_SERVER["REQUEST_URI"], '?'); ?>
                    <div class="search-titles-promotion flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2" style="width: 95%; display: none;" id="headerTableJobPromotion">
                        <div class="search-bar d-flex align-items-center justify-content-start" style="width: 80%; transform: translateX(-10px);">
                            <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                                <input type="text" class="form-control ps-5" placeholder="Search..." id="empSearchInput">
                                <i class="fa-solid fa-magnifying-glass position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: gray;"></i>
                            </div>
                        </div>

                        <div class="count" style="width: 8%;">
                            <select id="itemsPerPage" class="form-select" onchange="updateEmpItemsPerPage(this.value)">
                                <option disabled>Items</option>
                                <option value="10" <?= ($empPerPage == 10) ? 'selected' : '' ?>>10</option>
                                <option value="20" <?= ($empPerPage == 20) ? 'selected' : '' ?>>20</option>
                                <option value="50" <?= ($empPerPage == 50) ? 'selected' : '' ?>>50</option>
                            </select>
                        </div>

                        <div class="sort" style="width: 8%;">
                            <select class="form-select" onchange="updateEmpSort(this.value)">
                                <option disabled <?= empty($empSortColumn) ? 'selected' : '' ?>>Sort</option>
                                <option value="lname-asc" <?= $empSortColumn === 'lname' && $empSortOrder === 'asc' ? 'selected' : '' ?>>A-Z</option>
                                <option value="lname-desc" <?= $empSortColumn === 'lname' && $empSortOrder === 'desc' ? 'selected' : '' ?>>Z-A</option>
                                <option value="created_date-desc" <?= $empSortColumn === 'created_date' && $empSortOrder === 'desc' ? 'selected' : '' ?>>Recent</option>
                            </select>
                        </div>
                    </div>

                    <div class="promotion-list" style="width: 95%; margin: 10px auto; height: 50vh; display: none; flex-direction: column;" id="promotionList">
                        <table class="table table-bordered table-striped mt-3" style="width: 100%; border-collapse: separate; flex: 1 1 auto; display: block;">
                            <thead style="display: table-header-group; width: 100%; background: white; position: sticky; top: 0; z-index: 10; color: #000;">
                                <tr style="display: table; width: 100%; table-layout: fixed;">
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 30%;">
                                        <a href="<?= $currentUrl ?>?emp_sort=lname&emp_order=<?= ($empSortColumn === 'lname' && $empSortOrder === 'asc') ? 'desc' : 'asc' ?>&emp_perPage=<?= $empPerPage ?>&emp_page=1&tab=salaryManage" style="color:black; text-decoration:none;">
                                            Name <?= $empSortColumn === 'lname' ? ($empSortOrder === 'asc' ? '▲' : '▼') : '' ?>
                                        </a>
                                    </th>
                                    <th style="width: 20%;">
                                        <a href="<?= $currentUrl ?>?emp_sort=jobTitle&emp_order=<?= ($empSortColumn === 'jobTitle' && $empSortOrder === 'asc') ? 'desc' : 'asc' ?>&emp_perPage=<?= $empPerPage ?>&emp_page=1&tab=salaryManage" style="color:black; text-decoration:none;">
                                            Job Title <?= $empSortColumn === 'jobTitle' ? ($empSortOrder === 'asc' ? '▲' : '▼') : '' ?>
                                        </a>
                                    </th>
                                    <th style="width: 15%;">Salary</th>
                                    <th style="width: 15%;">
                                        <a href="<?= $currentUrl ?>?emp_sort=created_date&emp_order=<?= ($empSortColumn === 'created_date' && $empSortOrder === 'asc') ? 'desc' : 'asc' ?>&emp_perPage=<?= $empPerPage ?>&emp_page=1&tab=salaryManage" style="color:black; text-decoration:none;">
                                            Added At <?= $empSortColumn === 'created_date' ? ($empSortOrder === 'asc' ? '▲' : '▼') : '' ?>
                                        </a>
                                    </th>
                                    <th style="width: 15%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="empTableBody" style="display: block; overflow-y: auto; height: calc(50vh - 50px); width: 99.8%; margin-left: 2px;">
                                <?php if (!empty($validated)): ?>
                                    <?php $num = $empPage; foreach ($validated as $row): ?>
                                        <tr style="display: table; width: 100%; table-layout: fixed;">
                                            <td style="width: 5%;"><?= $num ?></td>
                                            <td style="width: 30%;"><?= htmlspecialchars($row['lname'] . ' ' . $row['fname']) ?></td>
                                            <td style="width: 20%;"><?= htmlspecialchars($row['jobTitle']) ?></td>
                                            <td style="width: 15%;"><?= htmlspecialchars($row['salary']) ?></td>
                                            <td style="width: 15%;"><?= date('F j, Y h:i A', strtotime($row['created_date'])) ?></td>
                                            <td style="width: 14%;">
                                                <button class="btn btn-sm btn-success me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#updateJobModal"
                                                    onclick='openUpdateModal(<?= $row["users_id"] ?>, <?= json_encode($row["jobTitle"]) ?>, <?= json_encode($row["salary_Range_From"]) ?>,
                                                    <?= json_encode($row["salary_Range_To"]) ?>, <?= json_encode($row["salary"]) ?>)'>
                                                    Promote
                                                </button>
                                                <button class="btn btn-sm btn-primary me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editJobModalHEhe"
                                                    onclick='openEditModalEdit(<?= $row["users_id"] ?>, <?= json_encode($row["jobTitle"]) ?>, <?= json_encode($row["salary_Range_From"]) ?>,
                                                    <?= json_encode($row["salary_Range_To"]) ?>, <?= json_encode($row["salary"]) ?>)'>
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    <?php $num++; endforeach; ?>
                                <?php else: ?>
                                    <tr style="display: table; width: 100%; table-layout: fixed;">
                                        <td colspan="6" class="text-center">No validated employees found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between align-items-center mt-1" style="flex-shrink: 0;">
                            <div>
                                Page <?= $empPage ?> of <?= $empTotalPages ?>
                            </div>
                            <div>
                                <a href="<?= $currentUrl ?>?emp_page=<?= max(1, $empPage - 1) ?>&emp_perPage=<?= $empPerPage ?>&emp_sort=<?= $empSortColumn ?>&emp_order=<?= $empSortOrder ?>&tab=salaryManage" class="btn btn-sm btn-outline-primary <?= ($empPage <= 1) ? 'disabled' : '' ?>">Previous</a>
                                <a href="<?= $currentUrl ?>?emp_page=<?= min($empTotalPages, $empPage + 1) ?>&emp_perPage=<?= $empPerPage ?>&emp_sort=<?= $empSortColumn ?>&emp_order=<?= $empSortOrder ?>&tab=salaryManage" class="btn btn-sm btn-outline-primary <?= ($empPage >= $empTotalPages) ? 'disabled' : '' ?>">Next</a>
                            </div>
                        </div>
                        <!-- ================================== PROMOTION MODAL SALARY ===================================== -->
                        <div class="modal fade" id="updateJobModal" tabindex="-1" aria-labelledby="updateJobModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="post" action="../../auth/authentications.php">
                                    <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                    <input type="hidden" name="promotion" value="true">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateJobModalLabel">Promote this Employee</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="hidden" name="job_id" id="updateJobId">

                                            <div class="mb-3">
                                                <label for="Job_Title" class="form-label">Job Title</label>
                                                <select name="job_title" id="Job_Title" class="form-select p-1 py-2 rounded-1">
                                                <option value="">Select Job Title</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="updateSalary" class="form-label">Salary Range From</label>
                                                <input type="number" class="form-control" name="salary_Range_From" id="updateSalaryFrom" min="0" value="">
                                            </div>

                                            <div class="mb-3">
                                                <label for="updateSalary" class="form-label">Salary Range TO</label>
                                                <input type="number" class="form-control" name="salary_Range_To" id="updateSalaryTo" min="0" value="">
                                            </div>

                                            <div class="mb-3">
                                                <label for="updateSalary" class="form-label">Official Salary</label>
                                                <input type="number" class="form-control" name="salary" id="updateSalary" min="0" value="">
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Promote</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- ================================== EDIT MODAL SALARY ===================================== -->
                        <div class="modal fade" id="editJobModalHEhe" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="post" action="../../auth/authentications.php">
                                    <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                    <input type="hidden" name="editSalary" value="true">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="editJobModalLabel">Edit Job Information</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                    <input type="hidden" name="users_id" id="editUserIdEdit">

                                        <div class="mb-3">
                                            <label for="Job_Title" class="form-label">Job Title</label>
                                            <select name="job_title" id="editJob_TitleEdit" class="form-select p-1 py-2 rounded-1">
                                            <option value="">Select Job Title</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="updateSalary" class="form-label">Salary Range From</label>
                                            <input type="number" class="form-control" name="salary_Range_From" id="editSalaryFromEdit" min="0" value="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="updateSalary" class="form-label">Salary Range TO</label>
                                            <input type="number" class="form-control" name="salary_Range_To" id="editSalaryToEdit" min="0" value="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="updateSalary" class="form-label">Official Salary</label>
                                            <input type="number" class="form-control" name="salary" id="editSalaryEdit" min="0" value="">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- hehe -->
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        populateJobTitles('#Job_Title');
        populateJobTitles('#editJob_TitleEdit');
        });

        function populateJobTitles(selector) {
        const sel = document.querySelector(selector);
        if (!sel) {
            console.warn(`No <select> found for ${selector}`);
            return;
        }

        fetch('../functions/api.php')            
            .then(r => r.json())
            .then(data => {
            if (!Array.isArray(data.jobTitles)) {
                console.error('Invalid data:', data);
                return;
            }
            sel.innerHTML = '<option value="">Select Job Title</option>';
            data.jobTitles.forEach(({ jobTitle }) => {
                sel.insertAdjacentHTML(
                'beforeend',
                `<option value="${jobTitle}">${jobTitle}</option>`
                );
            });
            })
            .catch(err => console.error('Job titles:', err));
        }
</script>
<script src="../../assets/js/hr/hrPromotion.js"></script>
<?php include '../../templates/Ufooter.php'?>