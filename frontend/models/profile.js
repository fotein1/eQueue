$(document).ready(function(){
    if (getCookie('user_id')) {
        url = domain_base + "/user/" + getCookie('user_id');
        $.ajax({
            url: url,
            type: 'GET',
            data: "{}",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function (data) {
                $(".user_details").append(
                    "<p> First name: " + data.user.first_name + "</p>" +
                    "<p> Last name: "+ data.user.last_name + "</p>" +
                    "<p> Email: "+ data.user.email + "</p>"
                );
            }
        });


        url = domain_base + "queue/user/" + getCookie('user_id');

        $.ajax({
            url: url,
            type: 'GET',
            data: "{}",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function (data) {
                $.each(data.queues, function (index, value) {
                    $("tbody#items").append("<tr>" +
                        "<td>"+ value.name + "</td>" +
                        "<td>"+ value.address + "</td>" +
                        "<td>"+ value.current_queue_number + "</td>" +
                        "<td>"+ value.queue_number + "</td>" +
                        "</tr>");
                });
            }
        });
    }

    if (getCookie('company_id')) {
        url = domain_base + "company/" + getCookie('company_id');

        $.ajax({
            url: url,
            type: 'GET',
            data: "{}",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function (data) {
                $(".company_details").append(
                    "<p> Company name: " + data.company.name + "</p>" +
                    "<p> Company address: "+ data.company.address + "</p>" +
                    "<p> Current queue number: "+ data.company.current_queue_number + "</p>"
                );
            }
        });

        url = domain_base + "queue/company/" + getCookie('company_id');

        $.ajax({
            url: url,
            type: 'GET',
            data: "{}",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function (data) {
                $.each(data.queued_users, function (index, value) {
                    $("tbody#items").append("<tr>" +
                        "<td>"+ value.first_name + "</td>" +
                        "<td>"+ value.last_name + "</td>" +
                        "<td>"+ value.email + "</td>" +
                        "<td>"+ value.queue_number + "</td>" +
                        "</tr>");
                });
            }
        });
    }
});