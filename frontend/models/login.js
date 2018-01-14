$(document).ready(function(){
    $("#login_form").click(function(){
        username = $('#username').val();
        password = $('#password').val();
        role = $('#role').val();

        if (role == 'user') {
            url = domain_base + "user/login";
        } else if (role == 'company') {
            url = domain_base + "company/login";
        } else {
            return;
        }
        
        data = {"username": username, "password": password};
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

            if (role == 'user') {
                setCookie('user_id', response.user_id, 1);
            } else if (role == 'company') {
                setCookie('company_id', response.company_id, 1);
            }

            $("#mainContent").empty();
            $("#mainContent").load("views/home.html");
        });
    });
});