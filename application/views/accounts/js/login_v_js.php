<script type="text/javascript">

    // LoginForm class definition
    function LoginForm(username, password) {
        // get username
        this.username = username;

        // get password
        this.password = password;

        this.postData = {username: this.username, password: this.password};

        // get csrf data from global variable
        this.postData[csrfTokenName] = csrfHash;

        // set login method
        this.login = $.ajax({
            type: 'post',
            url: siteUrl + "accounts/do_login",
            data: this.postData
        }).done(function(msg){
            // get and parse ajax response
            this.ajax_response = $.parseJSON(msg);

            // show message
            $('.validation-msg').html(this.ajax_response.message);
            // scroll to top
            $('body').ScrollTo();

            if (this.ajax_response.valid_user == 1) {
                // if admin user
                if (this.ajax_response.valid_admin == 1) {
                    window.location = siteUrl + this.ajax_response.redirect_to;
                }
                // if other user
            } else {
                // stay on this page, do nothing
            }
        })
    }


    $('form[name="login_form"]').submit(function(){
        // get username
        var username = $("#username").val();

        // get password
        var password = $("#password").val();

        // create a new instance of LoginForm
        var loginForm = new LoginForm(username, password);

        // instantiate login functionality
        loginForm.login;

        // disable form post
        return false;
    })


</script>