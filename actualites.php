<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/article.php";
require_once __DIR__ . "/templates/header.php";

// @todo On doit appeler getArticale pour récupérer les articles et faire une boucle pour les afficher
// $articles = getArticles($pdo, null, $page = 1);



if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
    for ($j = 1; $j <= $page; $j++) {
        $pages[] = $j;
    }
} else {
    $pages[0] = 1;
    $page = 1;
}

$articles = getArticles($pdo, _ADMIN_ITEM_PER_PAGE_, $page);
$totalArticles = getTotalArticles($pdo);

$totalPages = ceil($totalArticles / _ADMIN_ITEM_PER_PAGE_);

?>

<h1>TechTrendz Actualités</h1>
<?php


?>
<div class="row text-center">

    <form action="" method="POST">
        <div style="display: flex;margin-left:20px;">
            <h2 style="color: black;padding-right:10px;">Catégorie</h2><select name="categorie" class="btn btn-primary" id="" style="padding-right:10px;">
                <option value="Développement Web">Développement Web</option>
                <option value="Développement Mobile">Développement Mobile</option>
                <option value="DevOps">DevOps</option>
            </select>
            <input type="submit" name="valider" value="Valider " class="btn btn-outline-primary me-2">
        </div>
    </form>

    <?php
    foreach ($articles as $article) {
    ?>
        <div class="col-md-4 my-2 d-flex">
            <div class="card">
                <?php
                if ($article['image'] != null) {
                ?>
                    <img src="./uploads/articles/<?= $article['image'] ?>" class="card-img-top" alt="Les meilleurs outils DevOps">
                <?php
                } else {
                ?>
                    <img src="./assets/images/default-article.jpg" class="card-img-top" alt="Les meilleurs outils DevOps">
                <?php
                }
                ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $article['title'] ?></h5>
                    <a href="actualite.php?id=<?php echo $article['id'] ?>" class="btn btn-primary">Lire la suite</a>
                </div>
            </div>
        </div>

    <?php
    }
    ?>

    <!-- ajout fait -->

    <nav aria-label="Page navigation example">

        <ul class="pagination">
            <?php

            foreach ($pages as $pag) {

                if ($page == $pag) { ?>
                    <li class="page-item"><a class="page-link  active" href="?page=<?= $pag ?>"><?= $page ?> </a>
                    </li>
                    <?php for ($j = ($page + 1); $j <= $totalPages; $j++) { ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $j ?>"><?= $j ?> </a>
                        </li>
                    <?php } ?>

                <?php } else { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $pag ?>"><?= $pag ?> </a>
                    </li>
            <?php

                }
            } ?>
        </ul>
    </nav>


</div>

<?php require_once __DIR__ . "/templates/footer.php"; ?>