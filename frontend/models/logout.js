$(document).ready(function(){
    $(".logout_menu").click(function(){
        token = getCookie('token');

        if (getCookie('user_id')) {
            url = domain_base + "user/logout/" + getCookie('user_id');
        } else if (getCookie('company_id')) {
            url = domain_base + "company/logout/" + getCookie('company_id');
        } else {
            return;
        }
        
        data = {"token": token};
        data = JSON.stringify(data);

        $.ajax({
            url: url,
            method: 'DELETE',
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        })
        .done(function(response) {
            setCookie('token', '', 0);
            setCookie('user_id', '', 0);
            setCookie('company_id', '', 0);

            $("#mainContent").empty();
            $("#mainContent").load("views/home.html");
        });
    });
});