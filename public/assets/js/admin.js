$(function () {
    const url = window.location.pathname;
    if (USER_ACCESS_TOKEN === null) {
        document.location.href = '/';
    }
    const getUsers = () => {
        $.ajax({
            type: 'POST',
            url: API_GET_USERS,
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
    getUsers();
});