<?php
session_start();
require_once 'config.php';
//only logged users can open this page
if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit();
}
$userId=$_SESSION['user_id'];
$flash=$_SESSION['flash']?? '';
unset($_SESSION['flash']);
//waiting for approval
$stmt=$conn->prepare("SELECT id, title,due_date FROM pending_actins WHERE user_id= ?AND status='pending'ODER BY created_at DESC");
$stmt->bind_param("i",$userId);
$stmt->execute();
$pending=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
//approval tasks
$stmt=$conn->prepare("SELECT id,title,due_date,done FROM tasks WHERE use_id= ? ORDER BY done ASC ,created_at DESC");
$stmt->bind_param("i",$userId);
$stmt->execute();
$pending=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>DROP - Home</title>
        <link rel="stylesheet" href="home.css">
    </head>
    <body>
        <div class="wrap">
            <!--top bar-->
            <div class="topbar">
                <h1>DROP</h1>
                <div>
                    Hi,<?= htmlspecialchars($_SESSION['name'])?>
                </div>
            </div>
            <p class="promise">DROP never acts without your permission</p>
            <?php if ($flash !== ''): ?>
                <div class="flash"><?=htmlspecialchars($flash); ?> </div>
                <?php endif ;?>
                <!--box-box-->
                <div class="box">
                    <h2>DROP something here</h2>
                    <form action="drop.php" method="post">
                        <textarea name="content" maxlength="5" placeholder="paste a link,a note,a deadline,an invoice..."></textarea>
                        <button type="submit" class="dbtn">DROP it</button>
                    </form>
                </div>
                <!--approval-->
                <h3 class="title">
                    waiting for your approval
                    do you want me to save it
                    <span class="count"><?= count($pending); ?>/span>
                </h3>
                <?php if(count($pending) === 0): ?>
                    <p class="empty">Nothing waiting.DROP something above.</p>
                    <?php endif ; ?>
                <?php foreach($pending as $p): ?>
                    <from class="card proposal" action="action.php" method="post">
                        <input type="hidden" name="id" value="<?= (int) $p['id']; ?>">
                        <label>Task</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($p['title']); ?>" required>
                        <label>Date(optional)</label>
                        <input type="date" name="due_date" value="<?= htmlspecialchars($p['due_date'] ?? ''); ?>">
                        <div class="proposal-buttons">
                            <button type="submit" name="approve" class="btn-approve">Approve</button>
                            <button type="submit" name="dismiss" class="btn-dismiss" formnovalidate>Dismiss</button>
                        </div>
                    </from>
                <?php endforeach ; ?>
                <!--yessss to task-->
                <h3 class="title">
                    My tasks
                    <span class="count"><?= count($tasks); ?></span>
                </h3>
                <?php if(count($tasks) === 0): ?>
                    <p class="empty">No tasks yet.Approved proposals show up here.</p>
                <?php endif ; ?>
                <?php foreach($tasks as $t) : ?>
                    <div class="card task <?= $t['done'] ? 'done' :''; ?>"></div>
                    <div>
                        <div class="task-title"><?= htmlspecialchars($t['title']); ?></div>
                        <div class="task-date"><?=$t['due_date'] ? htmlspecialchars($t['due_date']) : 'No date';?></div>
                    </div>
                <?php endforeach ; ?>
        </div>
    </body>
</html>