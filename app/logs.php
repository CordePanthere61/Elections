<?php

require "functions.php";
if (!$_SESSION['is_admin']) {
    redirect("home.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Résultats</title>
    <link rel="stylesheet" href="../stylesheets/style.css">
</head>
<body>

<?php include_once "shared/navbar.php" ?>

<div class="container">
    <h2 class="my-4 border-bottom border-dark">Logs</h2>

    <div class="logs-container">
        <?php
            $db = buildDataBase();
            $result_logs = $db->query("SELECT * FROM logs ORDER BY log_id DESC");
            $data_logs = array();
            while ($row = $db->fetch($result_logs)) {
                $data_logs[] = $row;
            }
            $db->close();
            foreach ($data_logs as $log) {
                ?>
                <p class="text-light px-5 py-2 m-0 border-bottom border-light"><?= $log['time_stamp']?>, <?= $log['description']?>, <?= $log['ip_address']?></p>
                <?php
            }
        ?>
    </div>
</div>
</body>
</html>