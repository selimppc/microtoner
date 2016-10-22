            // LoginForm class definition
            function LoginForm() {
                // get username
                this.username = $("#username").val();

                // get password
                this.password = $("#password").val();

                // set login method
                this.login = $.ajax({
                    type: 'post',
                    url: "<?php echo site_url(); ?>/accounts/do_login",
                    data: {username: this.username, password: this.password}
                }).done(function(msg){
                    // get and parse ajax response
                    this.ajax_response = $.parseJSON(msg);

                    // show message
                    $('.validation-msg').html(this.ajax_response.message);

                    // based on response redirect user to appropriate page
                    if(this.ajax_response.valid_user == 1 && this.ajax_response.valid_admin == 1) {
                        window.location = "<?php echo site_url(); ?>/" + this.ajax_response.redirect_to;
                    } else if(this.ajax_response.valid_user == 1) {
                        window.location = "<?php echo site_url(); ?>/" + this.ajax_response.redirect_to;
                    } 
                })
            }

            // what login button will do? 
            $('#do_login').click(function(){
                // create a new instance of LoginForm
                var loginForm = new LoginForm();

                // instantiate login functionality
                loginForm.login;

                // disable form post
                return false;
            })