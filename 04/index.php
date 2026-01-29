<?php require "includes/header.php"; ?> <!-- requires header -->

<main class="container mt-5">
    <h1 class="text-center mb-4">Contact Bake It Till You Make It Bakery</h1> <!-- header for the contact section -->
    <form action="process.php" method="post" class= "row g-3 needs-validation" novalidate> <!-- creating form that send the info to process.php -->
        <fieldset class="border p-4 rounded shadow-sm bg-white">
            <legend class="float-none w-auto px-3">Contact Info</legend>
            <div class="col-md-6 mb-3">
                <label for="fname" class="form-label">First Name<span class="text-danger">*</span></label> <!-- making the submission boxes for the form first name last name email and message -->
                <input type="text" name="fname" id="fname" class="form-control" minlength="2"  required/>
                <div class="invalid-feedback">
                    Please enter your first name (at least 2 characters).
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" name="lname" id="lname" class="form-control" />
            </div>
            <div class="col-12 mb-3">
                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control" required/>
                <div class="invalid-feedback">
                    Please enter a valid email address. 
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="message" class="form-label">Message<span class="text-danger">*</span></label>
                <textarea name="message" id="message" rows="5" minlength="10" class="form-control" required 
                placeholder="Write Your Message Here..."></textarea>
                <div class="invalid-feedback">
                    Please enter a message (at least 10 characters).
                </div>
            </div>
            <div class="col-12 d-grid">
                <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
        </fieldset>
        
    </form>
</main>

<?php require "includes/footer.php"; ?> <!-- requires the footer.php file -->

