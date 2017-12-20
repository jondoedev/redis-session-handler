<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/../src/CustomHandler.php'; ?>
<?php use Engine\CustomHandler as Handler; ?>

    <div class="container" style="margin-left: 35%;margin-top: 10%">
        <div class="col-sm-6 col-sm-offset-3">
            <form method="POST">
                <div class="form-group">
                    <label for="Name">Key:</label>
                    <input type="text" class="form-control" id="name" name="key">
                </div>
                <div class="form-group">
                    <label for="Value">Value:</label>
                    <input type="text" class="form-control" id="value" name="value">
                </div>
                <button type="submit" class="btn btn-group-sm">Add to Session</button>
                <a href="<?= \App\App::$config['base_url'] ?>/delete" class="btn btn-danger">Destroy session</a>
            </form>
        </div>
        <div class="container data" style="padding: 3%;margin-top: 5%;margin-right: 50%;width: 70%; border: 1px solid black">
            <p><strong>Current Session:</strong><h5><?= Handler::Prefix . session_id();?></h5></p>
            <strong>Session Data:</strong>
            <pre><?php var_dump($_SESSION);?></pre>
        </div>
    </div>
<?php require_once '_footer.php';

