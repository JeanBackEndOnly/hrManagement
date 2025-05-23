<?php include '../templates/header.php'; ?>

<main id="main" class="installer-page m-1 text-center">
    <div class="container">
        <div class="row">
            <div class="">
                <div class="card">
                    <div class="body-header m-2">
                        <h1 class="text-center">Install System</h1>
                    </div>
                    <div class="card-body">
                        <form id="install-form">

                            <div class="mb-2">
                                <h6>System Logo</h6>
                                <div class="custom-file  ">
                                    <input type="file" class="custom-file-input d-none" accept="image/*"
                                        id="systemLogo">
                                    <label class="custom-file-label btn btn-secondary" for="systemLogo">Choose
                                        file</label>
                                </div>
                                <div class="mb-1">
                                    <h6>Preview</h6>
                                    <input type="hidden" name="system_logo" value="">
                                    <img src="https://placehold.co/150x150" class="img rounded preview" alt="">
                                </div>
                                <h5>System Information</h5>
                                <div class="input-group mb-2 row justify-content-center ">
                                    <div class="col-md-4">  
                                        <input type="text" class="form-control" name="system_title"
                                            placeholder="System Title" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="system_description"
                                            placeholder="System Description" required>
                                    </div>
                                </div>
                            </div>

                            <h5>Admin Information</h5>
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="firstname" placeholder="First Name"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control col-md-4" name="middlename"
                                        placeholder="Middle Name (Optional)">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control col-md-4" name="lastname"
                                        placeholder="Last Name" required>
                                </div>  
                            </div>
                            <div class="mb-3 row">
                                <div class="mb-1 col-md-4">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="mb-1 col-md-4">
                                    <input type="text" class="form-control" name="username" placeholder="Username"
                                        required>
                                </div>
                                <div class="mb-1 col-md-4">
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                        required>
                                </div>

                            </div>
                            <div class="mb-1 text-center">
                                <button type="submit" class="btn btn-secondary">INSTALL</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>



<?php include '../templates/footer.php' ?>
<!-- 
<?php echo $_SERVER['SERVER_NAME'] ?> -->