$(function () {
    if (USER_ACCESS_TOKEN !== null) {
        document.location.href = '/dashboard/index';
    }
    $('body').on('submit','.ajax-form', function () {
        const form = $(this);
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function (json) {
                const data =  $.parseJSON(json);
                if (data.status === 1) {
                    console.log(data.access_token);
                    if(data.access_token) {
                        $.session.set("access_token", data.access_token);
                        $.notify('Вы авторизованы!',  'success');
                        window.setTimeout(function () {
                            document.location.href = "/";
                        }, 1000);
                    }else{
                        $.notify(data.message,'success');
                    }

                } else {
                    $.notify(data.message);
                }
                $('.login-box button').prop('disabled', false);

            },
            error:function () {
                $.notify('Произошла ошибка!');
            }
        });
        return false;
    });
})