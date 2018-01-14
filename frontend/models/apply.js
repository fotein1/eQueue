$(document).ready(function(){
    $("#category").click(function(){
        category = $('#category').val();
        if (category == null) {
            return;
        }

        url = domain_base + "company/category/" + category;
    
        $.ajax({
            url: url,
            type: 'GET',
            data: "{}",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function (data) {
                $(".select_company").attr("style", "display:block");
                $.each(data.companies, function (index, value) {
                    $("#company").append(
                        "<option value=" + value.company_id + ">Name: " + value.name + ", Address: " + value.address + "</option>"
                    );
                });
            }
        });
    });

    $("#apply_form").click(function(){
        category = $('#category').val();
        company = $('#company').val();

        url = domain_base + "queue/user/" + getCookie('user_id');

        data = {"company_id": company, "token": getCookie('token')};

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