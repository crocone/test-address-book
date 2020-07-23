<?php foreach($items as $item) : ?>
<li class="list-group-item contact-item" id="contact-<?= $item['id'] ?>">
    <div class="row w-100">
        <div class="col-12 col-sm-6 col-md-3 px-0">
            <img src="/<?= STORAGE_URL.$item['image'] ?>" style="max-width: 50%;" alt="<?= $item['name'] ?>" class="rounded-circle mx-auto d-block img-fluid">
        </div>
        <div class="col-12 col-sm-6 col-md-9 text-center text-sm-left">
            <a href="#" data-id="<?= $item['id'] ?>" class="btn btn-success float-right edit-contact">
                <i class="fa fa-edit"></i>
            </a>
            <label class="name lead"><?= $item['name'] ?></label>
            <br>
            <span class="text-muted"><?= $item['comment'] ?></span>
            <br>
            <span class="fa fa-phone fa-fw text-muted" data-toggle="tooltip" title="" data-original-title="<?= (new App\Model\Contact)->numberToText($item['phone']) ?>"></span>
            <span class="text-muted small"><?= $item['phone'] ?> - <?= (new App\Model\Contact)->numberToText($item['phone']) ?></span>
            <br>
            <span class="fa fa-envelope fa-fw text-muted" data-toggle="tooltip" data-original-title="" title=""></span>
            <span class="text-muted small text-truncate"><?= $item['email'] ?></span>
        </div>
    </div>
</li>
<?php endforeach; ?>