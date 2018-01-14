$(document).ready(function(){
    $("#mainContent").load("views/home.html");

    if (getCookie('token') && getCookie('user_id') ||  getCookie('company_id')) {
        $('.login_menu, .login_action').attr("style", "display:none");
        $('.register_menu, .register_action').attr("style", "display:none");
    } else {
        $(".logout_menu, .logout_action").attr("style", "display:none");
        $(".profile_menu, .profile_action").attr("style", "display:none");
    }

    if (getCookie('user_id')) {
        $('.update_menu, .update_action').attr("style", "display:none");
    }

    if (getCookie('company_id')) {
        $('.apply_menu, .apply_action').attr("style", "display:none");
    }
});