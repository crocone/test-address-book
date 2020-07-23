<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Логин</th>
        <th scope="col">Email</th>
        <th scope="col">Админ</th>
        <th scope="col">Добавлен</th>
        <th scope="col">Обновлен</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
        <th scope="row"><?= $item['id'] ?></th>
        <td><?= $item['name'] ?></td>
        <td><?= $item['email'] ?></td>
        <td><?= $item['is_admin'] ? 'Да' : 'Нет' ?></td>
        <td><?= date('Y-m-d h:i:s',$item['created_at']) ?></td>
        <td><?= date('Y-m-d h:i:s',$item['updated_at']) ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>