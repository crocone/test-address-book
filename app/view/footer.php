</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.session@1.0.0/jquery.session.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script src="/assets/js/bootstrap-filestyle.min.js"></script>
<script src="/assets/js/config.js"></script>
<?php foreach ($scripts as $script) : ?>
    <script src="/assets/js/<?= $script ?>"></script>
<?php endforeach; ?>
</body>
</html>
