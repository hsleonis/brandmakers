"use strict";
$(document).ready(function(){
/*******************************
TEST FORM VALIDATION
*******************************/
    $("#validation-test").validate({
	rules: {
	    normal_input: {
		required: true,    
	    },
	    username: {
		required: true,
		minlength: 5
	    },
	    email: {
		required: true,
		email: true
	    },
	    password: {
		required: true,
		minlength: 5
	    },
	    confirm_password: {
		required: true,
		minlength: 5,
		equalTo: "#password"
	    },
	    checkbox1: {
		required: true,
	    },
	    radio1: {
		required: true,
	    }
	},
	messages: {
	    normal_input: "This field is required",
	    username: {
		required: "Please enter a username",
		minlength: "Your username must consist of at least 5 characters"
	    },
	    email: "Please enter a valid email address",
	    password: {
		required: "Please provide a password",
		minlength: "Your password must be at least 5 characters long"
	    },
	    confirm_password: {
		required: "Please provide a password",
		minlength: "Your password must be at least 5 characters long",
		equalTo: "Please enter the same password"
	    },
	    checkbox1: "",
	    radio1: ""
	},
	
	errorElement: "span",
	
	submitHandler: function(form) {
	    $.ajax({
		type: "POST",
		data: $(form).serialize(),
		success: function(response) {
		    alert("Validated")
		}            
	    });
	}
    });//End

//ICHECK
    $('.blue input').iCheck({
	checkboxClass: 'icheckbox_square-blue',
	radioClass: 'iradio_square-blue',
    });

});//END