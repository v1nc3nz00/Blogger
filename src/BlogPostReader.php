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
    private static $blogContent = '';
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
                self::$blogContent .= "
<p class='lead'><h3>" . $post_blog["title"] . "</h3> by  " . $searchUsername["fullName"] . "</p> <p> " . $post_blog["body"] . "</p>";
            }
        }
        self::$postData = ["blogContent" => self::$blogContent,];
        /* echo 'var_dump from BlogPostReader::ReadPosts()';
         var_dump(self::$postData);*/
        return self::$postData;
    }
}