<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__.'/../src/CustomHandler.php'?>
<?php
use Engine\CustomHandler as Handler;
?>

    <div class="container" style="margin-left: 35%;margin-top: 10%;">
        <div class="col-sm-6 col-sm-offset-12">
            <form method="POST">
                <div class="form-group" style="text-align: left;">
                    <label for="Name">Current Session</label>
                    <input type="text" title="SessID" class="form-control" value="
                    <?php if(empty(session_id())){
                        echo 'Session destroyed successfully';
                    }else{
                        echo Handler::Prefix.session_id();
                    }?>
                    "readonly>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
<?php require_once __DIR__.'/_footer.php';