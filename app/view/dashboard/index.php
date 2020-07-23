<?php
    $scripts = ['contact.js']
?>
    <div class="row">
        <div class="col-md-8">
            <form class="form-inline my-2 search-form">
                <input class="form-control mr-sm-2 search-input" name="search" type="search" placeholder="Поиск контактов" aria-label="Найти котакт">
            </form>
        </div>
        <div class="col-md-4">
            <button class="btn btn-sm btn-success mt-3" data-toggle="modal" data-target="#addContact" >Добавить контакт</button>
        </div>
    </div>
    <hr>
    <div class="card card-default" id="card_contacts">
        <div id="contacts" class="panel-collapse collapse show" aria-expanded="true" style="">
            <ul class="list-group pull-down" id="contact-list" data-page='1' ></ul>
        </div>
    </div>
    <div class="text-center"><button class="btn btn-info load-more  mt-3">Загрузить еще</button></div>
    <div class="modal fade" tabindex="-1" id="addContact" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавление контакта</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="contact-form">
                        <div class="row">
                            <div class="col-6">
                                <input name="name" class="form-control" type="text" placeholder="Имя" autofocus required>
                            </div>
                            <div class="col-6">
                                <input name="phone" class="form-control" type="text" placeholder="Телефон" autofocus required>
                            </div>
                            <div class="col-6 mt-2">
                                <input name="contactImage" id="contact-image-upload" data-text="Фото контакта" class="filestyle" type="file"  accept=".jpg, .jpeg, .png" title="Изображение">
                            </div>
                            <div class="col-6  mt-2">
                                <input name="email"  class="form-control" id="email" type="email" placeholder="Email">
                            </div>
                            <div class="col-12  mt-2">
                                <textarea name="comment" class="form-control" placeholder="Комментарий"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit"  class="btn btn-primary submit-contact">Добавить</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="editContact" data-id="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование контакта</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="edit-contact-form">
                        <div class="row">
                            <div class="col-6">
                                <input name="name" class="form-control" type="text" placeholder="Имя" autofocus required>
                            </div>
                            <div class="col-6">
                                <input name="phone" class="form-control" type="text" placeholder="Телефон" autofocus required>
                            </div>
                            <div class="col-6 mt-2">
                                <input name="contactImage" id="new-contact-image-upload" data-text="Фото контакта" class="filestyle" type="file"  accept=".jpg, .jpeg, .png" title="Изображение">
                            </div>
                            <div class="col-6  mt-2">
                                <input name="email"  class="form-control" id="email" type="email" placeholder="Email">
                            </div>
                            <div class="col-12  mt-2">
                                <textarea name="comment" class="form-control" placeholder="Комментарий"></textarea>
                            </div>
                            <input type="hidden" name="id">
                        </div>
                        <div class="modal-footer">
                            <button type="submit"  class="btn btn-primary">Сохранить</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
