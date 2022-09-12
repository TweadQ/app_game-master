<div>
    <a href="users.php" class="text-blue-500 text-sm">
       <- retour 
    </a>
    <div class="text-center mb-16">
        <h1 class="text-blue-500 text-5xl  text-uppercase font-black pb-10 pt-16 "><?= $user["name"] ?></h1>
        <div class="">
            <p>Name : <?= $user["name"] ?></p>
            <p>Email : <?= $user["email"] ?></p>
        </div>
        <div class="pt-10">
            <a href="update.php?id=<?= $user["id"] ?>&name=<?= $user["name"] ?>" class="btn btn-success text-white">Modifier</a>
            <?php include("view/partials/_modal.php") ?>
        </div>
    </div>
</div>