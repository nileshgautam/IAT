<?php 

function gst_validator($gstnumber){

}
// function to validate mobile number should be 10 digit only.
function validateMobileNumber($mobilenumber){
    // var phoneno = /^\d{10}$/;
    if ($mobilenumber==MOBILENUMBER) {
        return true;
    }
    else {
        return false;
    }
}
?>