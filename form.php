<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php 
if (!isset($_SESSION["tasks"])) {
    $_SESSION["tasks"] = [];
}

if (!isset($_SESSION["completed_tasks"])) {
    $_SESSION["completed_tasks"] = [];
}

if (isset($_POST["title"]) && !empty($_POST["title"])) {
    $newTask = [
        "title" => $_POST["title"],
        "description" => $_POST["description"]
    ];
    $_SESSION["tasks"][] = $newTask;
}

if (isset($_POST["reset"])) {
    $_SESSION["tasks"] = [];
    $_SESSION["completed_tasks"] = [];
}

if (isset($_POST["remove"])) {
    unset($_SESSION["tasks"][$_POST["remove"]]);
}

if (isset($_POST["complete"])) {
    $index = $_POST["complete"];
    $_SESSION["completed_tasks"][] = $_SESSION["tasks"][$index];
    unset($_SESSION["tasks"][$index]);
}
?>

<div id="header">
<h1>TO-DO</h1>
<h2>Track the tasks you need to do !</h2>
</div>

<div id="task_input">
    <form method="POST">
    Title: <input type="text" name="title"><br>
    Description: <input type="text" name="description"><br>
    <input type="submit">
    </form>
</div>



<div>
    <form method="POST">
        <input type="hidden" name="reset" value="1">
        <input type="submit" value="Clear All Tasks">
    </form>
</div>

<div class="task_list">
    <h2>Pending Tasks</h2>
    <ul>
    <?php foreach ($_SESSION["tasks"] as $index => $task): ?>
        <li>
            <strong><?php echo htmlspecialchars($task["title"] ?? ''); ?></strong><br>
            <?php echo htmlspecialchars($task["description"] ?? ''); ?><br>

            <form method="POST" style="display:inline">
                <input type="hidden" name="remove" value="<?php echo $index; ?>">
                <input type="submit" value="Remove">
            </form>
            <form method="POST" style="display:inline">
                <input type="hidden" name="complete" value="<?php echo $index; ?>">
                <input type="submit" value="Completed">
            </form>
        </li>
    <?php endforeach; ?>
    </ul>
</div>


<div class="task_list">
    <h2>Completed Tasks</h2>
    <ul>
    <?php foreach ($_SESSION["completed_tasks"] as $index => $task): ?>
        <li>
            <strong><?php echo htmlspecialchars($task["title"] ?? ''); ?></strong><br>
            <?php echo htmlspecialchars($task["description"] ?? ''); ?>
        </li>
    <?php endforeach; ?>
    </ul>
</div>


</body>
</html>
