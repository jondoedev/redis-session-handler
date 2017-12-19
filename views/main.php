<?php require_once __DIR__ . '/_header.php'; ?>



<?php

?>

<!--    <form method="post" style="margin-top: 10%;margin-left: 35%">-->
<!--          <input type="text" name="key" value=""/>-->
<!--    <input type="submit" name="submit" value="Add">-->
<!--    </form>-->

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
                <button type="submit" class="btn btn-danger">Add to Storage</button>
                <a href="<?= \App\App::$config['base_url']?>/destroy" class="btn btn-primary">Destroy session</a>
            </form>
        </div>
        <div class="container data" style="padding: 3%;margin-top: 5%;margin-right: 50%;width: 50%; border: 1px solid black">

                <p><?php
                    foreach ($_REQUEST as $data){
                        echo $data;
                        }

                    ?></p>

        </div>
    </div>
<?php require_once '_footer.php';

