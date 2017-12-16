<?php require_once __DIR__ . '/_header.php'; ?>




    <div class="container" style="margin-left: 35%;margin-top: 10%">
    <div class="col-sm-6 col-sm-offset-3">
        <form method="POST">
            <div class="form-group">
                <label for="Name">Name:</label>
                <input type="text" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="Value">Value:</label>
                <input type="text" class="form-control" id="value">
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Remember me</label>
            </div>
            <button type="submit" class="btn btn-danger" value="/add">Add</button>
            <button type="submit" class="btn btn-primary">Destroy</button>
        </form>
    </div>
    </div>

<?php require_once '_footer.php';