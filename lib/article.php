
<?php

function getArticleById(PDO $pdo, int $id): array|bool
{
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

// function getArticles(PDO $pdo, int $limit = null, int $page = null):array|bool
// {

function getArticles(PDO $pdo, int $limit = null, int $page = null)
{

    /*
        @todo faire la requête de récupération des articles
        La requête sera différente selon les paramètres passés, commencer par le BASE de base
    */

    $query0 = $pdo->prepare("SELECT COUNT(*) as total FROM articles");
    $query0->execute();

    $total = $query0->fetch();
    $tmp = $total['total'] - $limit;

    if ($page == null) {

        $query = $pdo->prepare("SELECT * FROM articles WHERE id > $tmp");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    } else {
        $pagesNumber = $tmp / 10;
        ceil($pagesNumber);
    }

    if ($limit == null) {
        $query = $pdo->prepare("SELECT * FROM articles ORDER BY id DESC");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    } else {
        if ($page == 1) {
            $query = $pdo->prepare("SELECT * FROM articles WHERE id <= :total AND id > (:total - 10) ORDER BY id DESC");
            $query->bindParam(':total', $total['total'], PDO::PARAM_INT);
            $query->execute();


            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            $query = $pdo->prepare("SELECT * FROM articles WHERE id >= (:total - (10 * :page)) AND id < (:total - ((10 * :page) - 10)) ORDER BY id DESC");
            $query->bindParam(':total', $total['total'], PDO::PARAM_INT);
            $query->bindParam(':page', $page, PDO::PARAM_INT);
            $query->execute();


            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        if (isset($_POST['categorie'])) {
            $categorie = htmlspecialchars($_POST["categorie"]);

            $query = $pdo->prepare("SELECT id FROM categories WHERE name = :categorie");
            $query->bindParam(':categorie', $categorie, PDO::PARAM_STR);
            $query->execute();
            $id = $query->fetch();

            // $query1 = $pdo->prepare("SELECT * FROM articles WHERE category_id = :id");
            // $query1->bindParam(':id', $id, PDO::PARAM_STR);
            // $query1->execute();
            // $result = $query1->fetchall(PDO::FETCH_ASSOC);


            $query1 = $pdo->prepare("SELECT * FROM articles WHERE id >= (:total - (10 * :page)) AND id < (:total - ((10 * :page) - 10)) AND category_id = :id ORDER BY id DESC");
            $query1->bindParam(':total', $total['total'], PDO::PARAM_INT);
            $query1->bindParam(':page', $page, PDO::PARAM_INT);
            $query1->bindParam(':id', $id, PDO::PARAM_INT);
            $query1->execute();
            $result = $query1->fetchall(PDO::FETCH_ASSOC);

            return $result;


        }
    }
}

function getTotalArticles(PDO $pdo): int|bool
{
    /*
        @todo récupérer le nombre total d'article (avec COUNT)
    */

    $query = $pdo->prepare("SELECT COUNT(*) as total FROM articles");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result['total'];
}

function saveArticle(PDO $pdo, string $title, string $content, string|null $image, int $category_id, int $id = null): bool
{
    if ($id === null) {
        /*
            @todo si id est null, alors on fait une requête d'insertion
        */
        $query = $pdo->prepare("INSERT INTO `articles` (`category_id`, `title`, `content`, `image`) VALUES(:category_id, :title, :content, :image)");
        $query->bindValue(":category_id", $category_id, PDO::PARAM_INT);
        $query->bindValue(":title", $title, PDO::PARAM_STR);
        $query->bindValue(":content", $content, PDO::PARAM_STR);
        $query->bindValue(":image", $image, PDO::PARAM_STR);
        $query->execute();
    } else {
        /*
            @todo sinon, on fait un update
        */

        $query = $pdo->prepare("UPDATE `articles` SET title = :title, content = :content, image = :image WHERE id = :id");

        $query->bindValue(':id', $id, $pdo::PARAM_INT);
    }

    // @todo on bind toutes les valeurs communes

    $query->bindValue(":title", $title, PDO::PARAM_STR);
    $query->bindValue(":content", $content, PDO::PARAM_STR);
    $query->bindValue(":image", $image, PDO::PARAM_STR);

    return $query->execute();
}

function deleteArticle(PDO $pdo, int $id): bool
{

    /*
        @todo Faire la requête de suppression
    */

    $query = $pdo->prepare("DELETE FROM articles WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);


    $query->execute();
    if ($query->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}
