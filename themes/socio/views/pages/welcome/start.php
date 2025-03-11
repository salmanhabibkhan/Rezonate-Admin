<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="pt-5 pb-0 position-relative" style="background-image: url(<?= load_asset('images/jobs.jpg'); ?>); background-repeat: no-repeat; background-size: cover; background-position: top center;">

    <!-- Container START -->
    <div class="container">
        <div class="p-5  position-relative">

            <div class="row">
                <div class="job_heading_wrapper">
                    <div class="text-center">
                        <h1 class="text-white">Getting Started </h1>
                        <p class="text-white">This information will let us know more about you.</p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>


<div class="container">
    <div class="row g-3 mt-1">

        <div class="col-md-12 col-lg-6 vstack gap-3">



            <div class="card">

                <div class="card-body">

                    <!-- Jobs Listing -->
                    <div class="row">


                        <form id="signUpForm" enctype="multipart/form-data" method="post">
                            <!-- start step indicators -->
                            <div class="form-header d-flex mb-4">
                                <span class="stepIndicator">Profile Image</span>
                                <span class="stepIndicator">Social Profiles</span>
                                <span class="stepIndicator">Personal Details</span>
                            </div>
                            <!-- end step indicators -->
                              
                            <!-- step one -->
                            <div class="step" id="step1">
                                <p class="text-center mb-4">Create your account</p>
                                <div class="mb-3">
                                    <label for="">Profile Picture</label>
                                    <input type="file" <?php if(empty($userdata['avatar'])):?> data-ifrequired="required" <?php endif ;?> name="avatar" class="form-control mt-1" placeholder="Choose Cover Image">
                                </div>
                                <div class="mb-3">
                                    <label for="">Cover Picture</label>
                                    <input type="file" name="cover" <?php if(empty($userdata['cover'])):?> data-ifrequired="required" <?php endif ;?> class="form-control mt-1" placeholder="Choose Cover Image">
                                </div>
                                <!-- Skip button for step one -->
                                <button type="button" onclick="nextTab(0)" class="btn btn-success">Skip</button>
                            </div>
                            

                            <!-- step two -->
                            <div class="step">
                                <p class="text-center mb-4">Your presence on the social network</p>
                                <div class="mb-3">
                                    <input type="text" placeholder="Linked In"  name="linkedin" value="<?=(!empty($userdata['linkedin'])?$userdata['linkedin']:'#')?>">
                                </div>
                                <div class="mb-3">
                                    <input type="text" placeholder="Twitter" name="twitter" value="<?=(!empty($userdata['twitter'])?$userdata['twitter']:'#')?>">
                                </div>
                                <div class="mb-3">
                                    <input type="text" placeholder="Facebook" name="facebook" value="<?=(!empty($userdata['facebook'])?$userdata['facebook']:'#')?>">
                                </div>
                                <div class="mb-3">
                                    <input type="text" placeholder="Youtube" name="youtube" value="<?=(!empty($userdata['youtube'])?$userdata['youtube']:'#')?>">
                                </div>
                                <div class="mb-3">
                                    <input type="text" placeholder="Instagram" name="instagram" value="<?=(!empty($userdata['instagram'])?$userdata['instagram']:'#')?>">
                                </div>
                                <!-- Skip button for step two -->
                                <button type="button" onclick="nextTab(1)" class="btn btn-success">Skip</button>
                            </div>

                            <!-- step three -->
                            <div class="step">
                                <p class="text-center mb-4"></p>
                                <div class="mb-3">
                                    <input type="text" placeholder="First Name" data-ifrequired="required" name="first_name" value="<?=$userdata['first_name']?>">
                                </div>
                                <div class="mb-3">
                                    <input type="text" placeholder="Last Name" data-ifrequired="required" name="last_name" value="<?=$userdata['last_name']?>">
                                </div>
                                <div class="mb-3">
                                    <input type="text" placeholder="Mobile Phone " name="phone" value="<?=$userdata['phone']?>">
                                    <input type="hidden" placeholder="profile complete " name="is_profile_complete" value="1">
                                </div>
                                <!-- Skip button for step three -->
                                
                            </div>

                            <!-- start previous / next buttons -->
                            <div class="form-footer d-flex">
                                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            </div>
                            <!-- end previous / next buttons -->
                        </form>
                    </div>
                </div>



            </div>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>

<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab
    
    function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("step");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
    }
    
    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("step");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:
            submitForm();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }
    
    function nextTab(n) {
        var x = document.getElementsByClassName("step");
        x[currentTab].style.display = "none";
        currentTab = n + 1; // Update currentTab to match the skipped step
        showTab(currentTab);
    }
    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("step");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "" && y[i].getAttribute('data-ifrequired') == 'required') {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // and set the current valid status to false
                valid = false;
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("stepIndicator")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }
    
    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("stepIndicator");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
    }

    function submitForm() {
        var formData = new FormData($('#signUpForm')[0]);
        console.log(formData);
        $.ajax({
            type: 'POST',
            url: site_url + 'web_api/settings/update-user-profile', // Updated API endpoint
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle success
                alert("Profile updated successfully!");
                window.location=site_url;
            },
            error: function() {
                // Handle error
                alert("An error occurred while updating the profile.");
            }
        });
    }
</script>

<?= $this->endSection() ?>
