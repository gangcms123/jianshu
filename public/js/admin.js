$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

$(".post-audit").click(function (event) {
    var target = $(event.target);
    var post_id = target.attr('post-id');
    var status = target.attr('post-action-status');
    $.ajax({
        url: "/admin/posts/" + post_id + "/status",
        method: 'POST',
        data:{'status':status},
        dataType: 'json',
        success: function (data) {
            if (data.error != 0) {
                alert(data.message);
                return;
            }
            target.parent().parent().remove();
        }
    });
});