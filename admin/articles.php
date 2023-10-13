<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
adminOnly();

require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/article.php";
require_once __DIR__ . "/templates/header.php";



// @todo décommenter ce code une fois toutes les fonctions codées

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

<!-- @todo coder la boucle foreach pour afficher les articles -->
<h1 class="display-5 fw-bold text-body-emphasis">Articles</h1>
<div class="d-flex gap-2 justify-content-left py-5">
  <a class="btn btn-primary d-inline-flex align-items-left" href="article.php">
    Ajouter un article
  </a>
</div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titre</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($articles as $article) { ?>
      <tr>
        <th scope="row"><?= $article['id'] ?></th>
        <td><?= $article['title'] ?></td>
        <td><a href="article.php?id=<?= $article['id'] ?>">Modifier</a>
          | <a href="article_delete.php?id=<?= $article['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</a></td>
      </tr>
    <?php } ?>

  </tbody>
</table>

<!-- @todo coder la boucle foreach pour gérer les pages -->
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


<?php require_once __DIR__ . "/templates/footer.php"; ?>