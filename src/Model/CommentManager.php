<?php

namespace App\Model;

class CommentManager extends AbstractManager
{
    public const TABLE = 'comment';

    /**
     * Add a comment associated to an item
     *
     * @param string $content : the comment content
     * @param integer $id : the associated item's id
     * @return boolean
     */
    public function addCommentOnItem(string $content, int $id): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(content, item_id) VALUES (:content, :id)");
        $statement->bindValue(":content", $content, \PDO::PARAM_STR);
        $statement->bindValue(":id", $id, \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function selectAllByItem(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE item_id = :id");
        $statement->bindValue(":id", $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
