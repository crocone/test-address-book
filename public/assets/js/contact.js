$(function () {
    const url = window.location.pathname;
    if (USER_ACCESS_TOKEN === null) {
        document.location.href = '/';
    }
    const editContact = (id) => {
        $.ajax({
            type: 'POST',
            url: API_GET_CONTACT,
            data: {'id' : id},
            success: function (data) {
                const json = $.parseJSON(data);
                $('.edit-contact-form [name="name"]').val(json.name);
                $('.edit-contact-form [name="phone"]').val(json.phone);
                $('.edit-contact-form [name="email"]').val(json.email);
                $('.edit-contact-form [name="comment"]').val(json.comment);
                $('.edit-contact-form [name="id"]').val(json.id);
                $('#editContact').modal('show');
            },
            error: function () {
                $.notify('Произошла ошибка');
            }
        });
    }
    $('body').on('click','.edit-contact',function () {
        editContact($(this).data('id'));
        return false;
    });
    const getContactTemplate = (id) => {
        $.ajax({
            type: 'POST',
            url: API_GET_CONTACT_TEMPLATE,
            data: {'id': id},
            success: function (data) {
                try {
                    const json = $.parseJSON(data);
                    $.notify(json.message);
                } catch (e) {
                    if($.trim(data)){
                        const contactElement = $('#contact-'+id);
                        if(contactElement.length !== 0){
                            contactElement.replaceWith(data);
                        }

                    }
                }
            },
            error: function () {
                $.notify('Произошла ошибка');
            }
        });
    }

    $('.load-more').click(function () {
        getContacts($('#contact-list').data('page')+1);
    });

    const getContacts = (page = 1, search = null) => {
        $.ajax({
            type: 'POST',
            url: API_GET_CONTACTS,
            data: {'page' : page, 'search' : search},
            success: function (data) {
                try {
                    const json = $.parseJSON(data);
                    $.notify(json.message);
                } catch (e) {
                    const list = $('#contact-list');
                    list.data('page', page);
                    if(!$.trim(data)){
                        if(search !== null){
                            list.html('<p class="text-center">Ничего не найдено</p>');
                        }
                        $('.load-more').hide();
                    }else{
                        list.data('page', page);
                        if(page > 1) {
                            list.append(data);
                        }else{
                            list.html(data);
                        }
                    }
                }

            },
            error: function () {
                $.notify('Произошла ошибка');
            }
        });
    };
    $('.search-input').keyup(function () {
        getContacts(1,$(this).val());
    });
    $('.edit-contact-form').submit(function () {
        const data = new FormData($(this)[0]);
        const id = $(this).find('[name="id"]').val();
        $.ajax({
            type: 'POST',
            url: API_UPDATE_CONTACT,
            data: data,
            contentType: false,
            processData: false,
            success: function (data) {
                const json =  $.parseJSON(data);
                console.log(json);
                if (json.status === 1) {
                    getContactTemplate(id);
                    $.notify(json.message,'success');
                }else{
                    $.notify(json.message);
                }
                $('.edit-contact-form')[0].reset();
                $('#editContact').modal('hide');
            },
            error: function () {
                $.notify('Произошла ошибка');
            }
        });
        return false;
    });
    $('.contact-form').submit(function () {
        const data = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: API_ADD_CONTACT,
            data: data,
            contentType: false,
            processData: false,
            success: function (data) {
                const json =  $.parseJSON(data);
                if (json.status === 1) {
                    getContactTemplate(json.id);
                    $.notify(json.message,'success');
                }else{
                    $.notify(json.message,'success');
                }
                $('.contact-form')[0].reset();
                $('#addContact').modal('hide');
            },
            error: function () {
                $.notify('Произошла ошибка');
            }
        });
        return false;
    });
    const checkFileSize = (size) => {
        return size / 1024 / 1024 < 2;
    }
    $('#contact-image-upload').change(function () {
        if(!checkFileSize(this.files[0].size)){
            $.notify('Размер файла не может быть больше 2 мегабайт');
            $(this).val('');
        }
    });
    getContacts();
});