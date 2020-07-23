<div class="row">
    <div class="col-md-12 order-md-1">
        <h4 class="mb-3  mt-4">Настройки профиля</h4>
        <form class="needs-validation" id="profile-form" novalidate="">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Имя</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?= $user['name'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="" value="<?= $user['email'] ?>" required>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 mb-3 text-center">
                    <h5 class="text-info">Изменение пароля</h5>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="newPassword">Новый пароль</label>
                    <input type="password" name="newPassword" class="form-control" id="newPassword">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="confirmNewPassword">Подтверждение нового пароля</label>
                    <input type="password" name="confirmNewPassword" class="form-control" id="confirmNewPassword">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 mb-3">
                    <label for="password">Старый пароль</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Сохранить</button>
        </form>
    </div>
</div>