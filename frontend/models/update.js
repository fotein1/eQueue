$(document).ready(function(){
    $("#update_form").click(function(){
        url = domain_base + "queue/company/" + getCookie('company_id');

        data = {"token": getCookie('token')};
        data = JSON.stringify(data);

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        })
        .done(function(response) {
            $("#mainContent").empty();
            $("#mainContent").load("views/home.html");
        });
    });
});