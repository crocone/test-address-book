$(function () {
    if (USER_ACCESS_TOKEN !== null) {
        document.location.href = '/dashboard/index';
    }

    $('body').on('submit','.ajax-form', function () {
        if(validateCaptcha()) {
            const form = $(this);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                success: function (json) {
                    const data = $.parseJSON(json);
                    if (data.status === 1) {
                        console.log(data.access_token);
                        if (data.access_token) {
                            $.session.set("access_token", data.access_token);
                            $.notify('Вы авторизованы!', 'success');
                            window.setTimeout(function () {
                                document.location.href = "/";
                            }, 1000);
                        } else {
                            $.notify(data.message, 'success');
                        }

                    } else {
                        $.notify(data.message);
                    }
                    $('.login-box button').prop('disabled', false);

                },
                error: function () {
                    $.notify('Произошла ошибка!');
                }
            });
        }
        return false;
    });
    let code;
    function createCaptcha() {
        document.getElementById('captcha').innerHTML = "";
        const charsArray =
            "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%^&*";
        const lengthOtp = 5;
        let captcha = [];
        for (var i = 0; i < lengthOtp; i++) {
            const index = Math.floor(Math.random() * charsArray.length + 1);
            if (captcha.indexOf(charsArray[index]) === -1)
                captcha.push(charsArray[index]);
            else i--;
        }
        const canv = document.createElement("canvas");
        canv.id = "captcha";
        canv.width = 100;
        canv.height = 50;
        const ctx = canv.getContext("2d");
        ctx.font = "25px Georgia";
        ctx.strokeText(captcha.join(""), 0, 30);
        code = captcha.join("");
        document.getElementById("captcha").appendChild(canv); // adds the canvas to the body element
    }
    function validateCaptcha() {
        event.preventDefault();
        debugger
        if (document.getElementById("cpatchaTextBox").value !== code) {
            $.notify("Капча введена неверно! Попробуйте снова");
            createCaptcha();
            return false;
        }
        return  true;
    }
    createCaptcha();
})