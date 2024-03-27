$(document).ready(function(){
    $("#dj").hide();

    // Function to toggle between Lawyer and Customer registration forms
    $("#ditoggle").click(function(event){
        event.preventDefault(); // Prevent default button click behavior
        $("#dj").show();
        $("#di").hide();
    });
    
    $("#djtoggleButton").click(function(event){
        event.preventDefault(); // Prevent default button click behavior
        $("#di").show();
        $("#dj").hide();
    });

    // Function to validate email address format
    function validateEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    // Function to validate password match and length
    function validatePassword(password, confirmPassword) {
        return password === confirmPassword && password.length >= 6;
    }

    // Function to validate mobile number format
    function validateMobileNumber(mobileNumber) {
        var re = /^\d{10}$/; // Regular expression to match exactly 10 digits
        return re.test(mobileNumber);
    }

    // Validate form before submission
    $("form").submit(function(event) {
        var isValid = true;
        var form = $(this);

        // Check email format
        if (!validateEmail(form.find('input[type="email"]').val())) {
            alert("Invalid email address!");
            isValid = false;
        }

        // Check password length and match
        if (!validatePassword(form.find('input[type="password"]').val(), form.find('input[type="password"]').val())) {
            alert("Password should be at least 6 characters long and match confirm password!");
            isValid = false;
        }

        // Check mobile number format
        if (!validateMobileNumber(form.find('input[type="tel"]').val())) {
            alert("Mobile number should contain exactly 10 digits!");
            isValid = false;
        }

        // If form is not valid, prevent submission
        if (!isValid) {
            event.preventDefault();
        }
    });
})
