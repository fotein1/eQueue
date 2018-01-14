$(document).ready(function(){
    $("#home_view").click(function(){
        $("#mainContent").load("views/home.html");
    });

    $(".login_menu").click(function(){
        $("#mainContent").empty();
        $("#mainContent").load("views/login.html");
    });

    $(".register_menu").click(function(){
        $("#mainContent").empty();
        $("#mainContent").load("views/register.html");
    });

    $(".apply_menu").click(function(){
        $("#mainContent").empty();
        $("#mainContent").load("views/apply.html");
    });

    $(".profile_menu").click(function(){
        if (getCookie('user_id')) {
            $("#mainContent").empty();
            $("#mainContent").load("views/user_profile.html");
        }

        if (getCookie('company_id')) {
            $("#mainContent").empty();
            $("#mainContent").load("views/company_profile.html");
        }
    });

    $(".update_menu").click(function(){
        $("#mainContent").empty();
        $("#mainContent").load("views/update.html");
    });
});
