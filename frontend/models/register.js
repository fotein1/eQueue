$(document).ready(function(){
    $("#register_user_form").click(function(){
        username   = $('#username').val();
        password   = $('#password').val();
        email      = $('#email').val();
        first_name = $('#first_name').val();
        last_name  = $('#last_name').val();

        url = domain_base + "user/register";
        
        data = {
            "username": username,
            "password": password,
            "email": email,
            "first_name": first_name,
            "last_name": last_name
        };
        data = JSON.stringify(data);

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        })
        .done(function(response) {
            alert("sucess");
            setCookie('token', response.token, 1);
            setCookie('user_id', response.user_id, 1);

            $("#mainContent").empty();
            $("#mainContent").load("views/home.html");
        });
    });

    $("#register_company_form").click(function(){
        username = $('#username_company').val();
        password = $('#password_company').val();
        category = $('#category').val();
        name     = $('#name').val();
        address  = $('#address').val();

        url = domain_base + "company/register";
        
        data = {
            "username": username,
            "password": password,
            "category": category,
            "name": name,
            "address": address
        };
        data = JSON.stringify(data);

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        })
        .done(function(response) {
            setCookie('token', response.token, 1);
            setCookie('company_id', response.company_id, 1);

            $("#mainContent").empty();
            $("#mainContent").load("views/home.html");
        });
    });
});