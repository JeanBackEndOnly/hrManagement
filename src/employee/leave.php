<?php include '../../templates/Uheader.php';  include '../../templates/HN.php';?>
<style>
.hr {
    background: linear-gradient(40deg, #E53935, #e53835c2, #e538358f, #e538352f) !important;
    color: #fff !important;
}

.hrP{
    color: #fff !important;
    font-weight: bold !important;
}
</style>
<main>
    <div class="main-body w-100 h-100 m-0 p-0">
        <?= renderHeaderEmployee() ?>


        <div class="d-flex w-100 align-items-start" style="height: auto;">
            <?= renderNavEmployee() ?>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee mediaTitleMargin m-0 d-flex flex-row justify-content-start align-items-center col-md-11 col-11 flex-wrap" style="height: 5rem !important;">
                    <div class="h1 AnimationFinalfirst">
                        <h3 class="m-0 titleFont">FILLING LEAVE</h3>
                        <p style="font-size: 17px !important; margin-top: -1rem !important;"><span>You request a leave as if it's a important matter</span></p>
                    </div>
                </div>
                <div class="container rounded-2 shadow p-0 m-0 heightMediaContent mt-3 d-flex flex-column align-item-center justify-content-start">
                    <div class="title w-100 h-auto d-flex flex-column justify-content-center align-items-center p-0 m-0">
                        <h5 class="text-center txtMedia13">ZAMBOANGA PUERICULTURE CENTER ORG. NO.144 INC.</h5>
                        <h5 style="border-bottom: solid 1px #000;" class="txtMedia13s">APPLICATION FOR LEAVE</h5>
                    </div>
                    <div class="form col-md-12 col-12 d-flex justify-content-center align-items-center m-0 py-3 h-auto">
                        <form action="../../auth/authentications.php" method="post" clas="d-flex justify-content-center align-items-center py-3 m-0 w-100 mt-1">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                            <input type="hidden" name="LeaveEmployee" value="true">
                            <div class="col-md-12 d-flex flex-row justify-content-center align-items-center flex-wrap">
                                <div class="col-md-10 col-11 d-flex flex-row justify-content-between flex-wrap">
                                    <div class="col-md-4 d-flex flex-column col-12">
                                        <label class="ms-1" for="lname">Last Name</label>
                                        <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $employeeInfo["lname"] ?>">
                                    </div>
                                    <div class="col-md-4 col-11 d-flex flex-column col-12">
                                        <label class="ms-1" for="fname">First Name</label>
                                        <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $employeeInfo["fname"] ?>">
                                    </div>
                                    <div class="col-md-4 col-11 d-flex flex-column col-12">
                                        <label class="ms-1" for="mname">M.I.</label>
                                        <input type="text" name="mname" id="mname" class="form-control" value="<?php echo $employeeInfo["mname"] ?>">
                                    </div>
                                </div>
                                <div class="col-md-2 col-11 d-flex flex-column justify-content-center">
                                    <label class="ms-1" for="dateLeave">DATE OF FILING <span class="fw-bold" style="font-size: 12px; color: red;">(required)</span></label>
                                    <input required type="date" name="dateLeave" id="dateLeave" class="form-control">
                                </div>
                            </div>
                            <div class="positionDept col-md-12 col-12 d-flex flex-row justify-content-center align-items-center p-0 m-0 mt-3 flex-wrap">
                                <div class="position col-md-6 d-flex flex-column col-11">
                                    <label class="ms-1" for="position">POSITION</label>
                                    <input required type="text" name="position" class="form-control" id="position" value="<?php echo $employeeInfo["jobTitle"] ?>">
                                </div>
                                <div class="position col-md-6 d-flex flex-column col-11">
                                    <label class="ms-1" for="Dept">DEPARTMENT/SECTION</label>
                                    <input required type="text" name="department" class="form-control" id="Dept" value="<?php echo $employeeInfo["department"] . " DEPARTMENT" ?>">
                                </div>
                            </div>
                            <div class="applied col-md-12 col-12 d-flex flex-row h-auto justify-content-center align-items-center p-0 m-0 mt-2 flex-wrap">
                                <div class="label col-md-2 ms-2 mt-2">
                                    <label for="" class="fw-bold col-md-12"><span class="fw-bold" style="font-size: 12px; color: red;">(required)</span>LEAVE APPLIED FOR</label>
                                </div>
                                <div class="row col-md-2 col-11 d-flex flex-row">
                                    <label for="vacation"><input required type="radio" class="me-1" id="vacation" name="leaveType" value="vacation">Vacation Leave</label>
                                </div>
                                <div class="row col-md-2 col-11 d-flex flex-row">
                                    <label for="sick"><input required type="radio" class="me-1" id="sick" name="leaveType" value="sick">Sick Leave</label>
                                </div>
                                <div class="row col-md-2 col-11 d-flex flex-row">
                                    <label for="special"><input required type="radio" class="me-1" id="special" name="leaveType" value="special">Special Leave</label>
                                </div>
                                <div class="row col-md-12 col-11 d-flex flex-row">
                                    <label for="others">Others Specify</label>
                                    <input type="text" class="form-control me-1" id="others" name="others">
                                </div>
                            </div>
                            <div class="applied col-md-12 col-12 d-flex flex-row h-auto justify-content-center align-items-center p-0 m-0 mt-2 flex-wrap">
                                <label for="cp" class="fw-bold col-md-12 col-11">COURSE/PURPOSE <span class="fw-bold" style="font-size: 12px; color: red;">(required)</span><input required type="text" class="form-control col-11 col-md-11" id="cp" name="purpose"></label>
                            </div>
                            <div class="applied col-md-12 col-12 d-flex flex-row h-auto justify-content-center align-items-center p-0 m-0 mt-3 flex-wrap">
                                <div class="inclusiveDateFrom d-flex flex-column col-md-3 col-11">
                                    <label for="inclusiveDates">INCLUSIVE DATE FROM: <span class="fw-bold" style="font-size: 12px; color: red;">(required)</span></label>
                                    <input required type="date" name="inclusiveDateFrom" id="inclusiveDateFrom" class="form-control">
                                </div>
                                <div class="inclusiveDates d-flex flex-column col-md-3 col-11">
                                    <label for="inclusiveDateTo">INCLUSIVE DATES TO: <span class="fw-bold" style="font-size: 12px; color: red;">(required)</span></label>
                                    <input required type="date" name="inclusiveDateTo" id="inclusiveDateTo" class="form-control">
                                </div>
                                <div class="noDays d-flex flex-column col-md-6 col-11">
                                    <label for="daysOfLeave">NO. OF DAYS <span class="fw-bold" style="font-size: 12px; color: red;">(required)</span></label>
                                    <input required type="number" name="daysOfLeave" id="daysOfLeave" class="form-control">
                                </div>   
                            </div>
                            <div class="applied col-md-12 col-12 d-flex flex-row h-auto justify-content-center align-items-center p-0 m-0 mt-2 flex-wrap">
                                <label for="cp" class="fw-bold col-md-12 col-11">CONTACT NO. WHILE ON LEAVE <span class="fw-bold" style="font-size: 12px; color: red;">(required)</span><input required type="text" class="form-control col-11 col-md-11" id="cp" name="contact"></label>
                            </div>
                            <div class="text col-md-12 col-12 d-flex align-items-center justify-content-center">
                                <p class="text-start col-md-12 col-11">
                                    I hereby pledge to report for work immediately the following day after expiration of my approved leave of absence unless <br>
                                    otherwise duly extended. MMy failure to do so shall subject me to disciplinary action
                                </p>
                            </div>
                            <div class="recommending col-md-12 col-12 d-flex flex-row align-items-center justify-content-center m-0 mt-4 p-0">
                                <p class="fw-bold col-md-5 col-5">Reommending Approval: </p>
                                <div class="signiture col-md-5 col-5">
                                    <p style="border-bottom: solid 1px #000;" class="m-0"></p>
                                    <p class="text-center">Signiture of Applicant</p>
                                </div>
                            </div>
                            <div class="recommending col-md-12 col-12 d-flex flex-row align-items-center justify-content-center m-0 mt-4 p-0 flex-wrap gap-2">
                                <div class="sectionHEad col-md-4 col-11">
                                    <label class="fw-bold" for="sectionHead">Section Head <span class="fw-bold" style="font-size: 12px; color: red;">(required)</span></label>
                                    <input required type="text" class="form-control" id="sectionHead" name="sectionHead">
                                </div>
                                <div class="departmentHead col-md-4 col-11">
                                    <label class="fw-bold" for="departmentHead">Department Head <span class="fw-bold" style="font-size: 12px; color: red;">(required)</span></label>
                                    <input required type="text" class="form-control" id="departmentHead" name="departmentHead">
                                </div>
                            </div>
                            <!-- ================================ ADMIN ONLY ================================ -->
                            <div class="approvalContent col-md-12 col-12 p-0 m-0 mt-4 d-flex flex-column h-auto align-items-center justify-content-start" 
                                style="border: solid 1px #000;">
                                <div class="detailsTitle col-md-12 col-11" style="border-bottom: solid 1px #000;">
                                    <h5 class="text-center my-1">DETAILS OF ACTION ON APPLICATION</h5>
                                </div>
                                <div class="row col-md-12 col-11 d-flex flex-row justify-content-center align-items-center h-auto flex-wrap p-2 m-0">
                                    <div class="titleContents col-md-7 col-12 d-flex flex-column p-0 m-0">
                                        <div class="entities d-flex col-12 flex-row justify-content-center align-items-center">
                                            <p class="col-md-3 col-3 m-0 mt-3"></p>
                                            <label class="col-md-3 col-3 text-center" for="">VACATION</label>
                                            <label class="col-md-3 col-3 text-center" for="">SICK</label>
                                            <label class="col-md-3 col-3 text-center" for="">SPECIAL</label>
                                        </div>
                                        <div class="Attributes d-flex flex-column justify-content-center align-items-center col-md-12 col-12">
                                            <div class="row col-md-12 col-12 m-0 mt-2 d-flex flex-row justify-content-center align-items-center">
                                                <p class="col-md-3 col-3 p-0 m-0">Balance as of: </p>
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                            </div>
                                            <div class="row col-md-12 col-12 m-0 mt-2 d-flex flex-row  justify-content-center align-items-center">
                                                <p class="col-md-3 col-3 non-editable p-0 m-0">Leave Earned: </p>
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                            </div>
                                            <div class="row col-md-12 col-12 m-0 mt-2 d-flex flex-row  justify-content-center align-items-center">
                                                <p class="col-md-3 col-3 non-editable p-0 m-0">Total Leave Credits as of: </p>
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                            </div>
                                            <div class="row col-md-12 col-12 m-0 mt-2 d-flex flex-row  justify-content-center align-items-center">
                                                <p class="col-md-3 col-3 non-editable p-0 m-0">Less this Leave: </p>
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                            </div>
                                            <div class="row col-md-12 col-12 m-0 mt-2 d-flex flex-row  justify-content-center align-items-center">
                                                <p class="col-md-3 col-3 non-editable p-0 m-0">Balance to Date: </p>
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                                <input type="text" class="col-md-3 col-3 non-editable">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recommendation col-md-5 col-12 mt-4">
                                        <div class="d-flex flex-column col-md-12 col-11">
                                            <label for="" class="fw-bold">Reommendation for:</label>
                                            <div class="row d-flex col-md-11 col-11 flex-row justify-content-start align-items-center m-0 p-0">
                                                <input type="radio" class="col-md-1 col-1 non-editable" id="approved" name="approved">
                                                <label class="col-md-1 col-1 non-editable text-start" for="approved">Approved</label>
                                            </div>
                                            <div class="row d-flex col-md-11 col-11 flex-row justify-content-start align-items-center m-0 p-0">
                                                <input type="radio" class="col-md-1 col-1 non-editable" id="Disapproval">
                                                <label class="col-md-7 col-9 text-start non-editable" for="Disapproval">Disapproval due to:</label>
                                                <textarea name="Disapproval" id="" class="non-editable"></textarea>
                                            </div>
                                            <div class="admin mt-5">
                                                <p style="border-bottom: solid 1px #000" class="m-0"></p>
                                                <p class="text-center">Administrator</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="updateModalEBG" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md modal-dialog-start">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel">Leave Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modalConfirmation px-3 py-4 text-center">
                                            <h5 class="mb-0">Are you sure you want to submit Leave request??</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Save Changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="buttonSubmit mt-3 col-md-12 col-11 d-flex justify-content-end">
                        <button type="button" id="updateButtonEBG" class="btn btn-success col-md-12 col-3" data-bs-toggle="modal" data-bs-target="#updateModalEBG">
                            Submit
                        </button>
                    </div>
                </div>
                <?= mediaNavEmployee() ?>
            </div>
        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (leaveRequest) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Leave Request Successfully send!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['success']);
        }
        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
    });
</script>
<?php include '../../templates/Ufooter.php'?>