<div class="header-employee d-flex flex-row justify-content-between align-items-center" style="min-height: 7rem; min-width: 95%;">
    <div class="h1">
        <h3 class="m-0">EMPLOYEE PROFILE</h3>
    </div>
    <div class="navigations">
        <button type="button" id="Personal" onclick="activateTab(this); personalInfo()" class="tab-btn active">Personal Information</button>
        <button type="button" id="Family" onclick="activateTab(this); familyBG()" class="tab-btn">Family Background</button>
        <button type="button" id="Educational" onclick="activateTab(this); educationalBG()" class="tab-btn">Educational Background</button>
    </div>
    <div class="buttonUpdate">
        <button type="button" id="updateButton" class="btn" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>
        <button type="button" id="updateButtonFBG" class="btn" data-bs-toggle="modal" data-bs-target="#updateModalFBG">Update</button>
        <button type="button" id="updateButtonEBG" class="btn" data-bs-toggle="modal" data-bs-target="#updateModalEBG">Update</button>
    </div>
</div>
