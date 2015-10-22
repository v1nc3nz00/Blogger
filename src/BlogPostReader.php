<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 20/10/2015
 * Time: 12:44
 */
class BlogPostReader
{
    private static $postData = [];
    private static $post_message = "SELECT user_id, title, body FROM posts WHERE TRUE;";

    public static function ReadPosts()
    {
        $options = [];
        $response = DBConnector::Connect(self::$post_message, $options);
        $sth = $response->fetchAll(PDO::FETCH_BOTH);

        if ($sth != null and $sth != '') {
            foreach ($sth as $post_blog) {
                $searchUsername = DBConnector::Connect("SELECT users.fullName From users where users.id=" . $post_blog["user_id"] . ";", $options);
                $searchUsername = $searchUsername->fetch(PDO::FETCH_BOTH);
                self::$postData = array_merge(self::$postData, [["blogTitle" => $post_blog["title"], "blogAuthor" => $searchUsername["fullName"], "blogBody" => $post_blog["body"]],]);
            }
        }
        return self::$postData;
    }
}