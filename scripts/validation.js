$().ready(function() {
    // validate signup form (on focus out event of each element)
    $("#sign-up-form").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            pass_one: {
                required: true,
                minlength: 5
            },
            pass_two: {
                required: true,
                minlength: 5,
                equalTo: "#pass-one"
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            first_name: "Please enter your first name.",
            last_name: "Please enter your last name.",
            pass_one: {
                required: "Please provide a password.",
                minlength: "Your password must be at least 5 characters long."
            },
            pass_two: {
                required: "Please provide a password.",
                minlength: "Your password must be at least 5 characters long.",
                equalTo: "Please enter the same password as above."
            },
            email: "Please enter a valid email address."
        },
        onfocusout: function(element) {
            this.element(element);
        }
    });
    
    // validate login form (on focus out event of each element)
    $("#login-form").validate({
        rules: {
            p: {
                required: true
            },
            e: {
                required: true,
                email: true
            }
        },
        messages: {
            p: {
                required: "Please provide a password.",
            },
            e: "Please enter a valid email address."
        },
        onfocusout: function(element) {
            this.element(element);
        }
    });
    
    // validate sell form (on focus out event of each element)
    $("#sell-form").validate({
        rules: {
            title: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            title: {
                required: "Please provide a title.",
            },
            description: {
                required: "Please provide a description.",
            },
        },
        onfocusout: function(element) {
            this.element(element);
        }
    });
});