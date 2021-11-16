<?php

namespace App\Controller;

use App\Model\CommentManager;
use App\Model\ItemManager;

class CommentController extends AbstractController
{
    /**
     * Add a comment for a given item using an HTML form
     *
     * @param integer $id
     * @return string
     */
    public function add(int $id = 0): string
    {
        // Get the item
        $itemManager = new ItemManager();
        $item = $itemManager->selectOneById($id);
        // Check if item exists
        if (false === $item) {
            header("Location: /items");
            return "";
        }
        // Form validation
        $error = false;
        if (isset($_POST["comment"])) {
            $comment = trim($_POST["comment"]);
            if (empty($comment)) {
                $error = true;
            } else {
                // I can record the comment
                if ((new CommentManager())->addCommentOnItem($comment, $item['id'])) {
                    header("Location: items/show?id=" . $item["id"]);
                    return "";
                } else {
                    header("Location: error");
                    return "";
                }
            }
        }
        return $this->twig->render("Comment/add.html.twig", [
            "item" => $item,
            "error" => $error,
        ]);
    }
}
