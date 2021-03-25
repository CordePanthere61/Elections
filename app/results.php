<?php

require "functions.php";
if (!$_SESSION['is_admin']) {
    redirect("home.php");
}
updateNbVotesForOptions();

include_once "shared/navbar.php"
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

    <div class="container canvas-container">
        <h2 class="my-4 border-bottom border-dark">Résultats des sondages actifs</h2>
    </div>
</body>
</html>
<?php

function generateOptions($db, $pollId)
{
    $index = 0;
    $options = getPollOptions($db, $pollId);
    foreach ($options as $option) {
        if ($index + 1 == count($options)) {
            echo "'" . $option['title'] . '\'';
        } else {
            echo "'" . $option['title'] . '\',';
        }
        $index++;
    }
}

function generateOccurrencesForOptions($db, $pollId)
{
    $index = 0;
    $options = getPollOptions($db, $pollId);
    foreach ($options as $option) {
        if ($index + 1 == count($options)) {
            echo "'" . $option['nb_votes'] . '\'';
        } else {
            echo "'" . $option['nb_votes'] . '\',';
        }
        $index++;
    }
}

function generateTitle($db, $pollId)
{
    echo getPollname($db, $pollId);
}
?>

<script src="../javascripts/vendor/Chart.bundle.min.js"></script>
<script type="text/javascript">
    const container = document.querySelector(".container");

    <?php
    $db = buildDatabase();
    $pollsIds = getPollsIds($db);
    $pollsNb = count($pollsIds);

    ?>
    function createCanvas(id) {
        const canvas = document.createElement("canvas");
        canvas.id = id;
        canvas.width = 10;
        canvas.height = 2;
        container.append(canvas);
    }

    <?php

    for ($i = 0; $i < $pollsNb; $i++) {?>
        createCanvas(<?= $i; ?>)
    <?php } ?>
    let ctx = null;
    let chart = null;
    <?php

    for ($i = 0; $i < $pollsNb; $i++) { ?>

    ctx = document.getElementById(<?= $i ?>).getContext('2d');
    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php generateOptions($db, $pollsIds[$i][0]);?>],
            datasets: [{
                label: '<?php generateTitle($db, $pollsIds[$i][0]); ?>',
                data: [<?php generateOccurrencesForOptions($db, $pollsIds[$i][0]); ?>],
                backgroundColor: '#888',
                borderWidth: 1,
                borderColor : '#000'
            }]
        }
    });
    <?php }
    $db->close();
    ?>
</script>