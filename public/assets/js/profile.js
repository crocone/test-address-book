$(function () {
    const url = window.location.pathname;
    if (USER_ACCESS_TOKEN === null) {
        document.location.href = '/';
    }
    const getUserProfile = () => {
        $.ajax({
            type: 'POST',
            url: API_GET_PROFILE_TEMPLATE,
            success: function (data) {
                try {
                    const json = $.parseJSON(data);
                    $.notify(json.message);
                } catch (e) {
                    if($.trim(data)){
                        const content = $('.content-block');
                        content.html(data);
                    }
                }
            },
            error: function () {
                $.notify('Произошла ошибка');
            }
        });
    };
    const updateProfile = (form) => {
            $.ajax({
                type: 'POST',
                url: API_UPDATE_PROFILE,
                data: form.serialize(),
                success: function (data) {
                    const json = $.parseJSON(data);
                    if(json.status === 1){
                        getUserProfile();
                        $.notify(json.message,'success');
                    }else{
                        $.notify(json.message);
                    }
                },
                error: function () {
                    $.notify('Произошла ошибка');
                }
            });
    }
    $('.content-block').on('submit','#profile-form',function () {
        updateProfile($(this));
        return false;
    });

    getUserProfile();
});