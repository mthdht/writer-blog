<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework;

use Framework\Database\QueryBuilder;
use Framework\Routing\Router;

class Application
{
    public function run()
    {

        /*$data = QueryBuilder::table('articles')
            ->insert([
                    "title" => "my title 10",
                    "content" => "lorem ipsum 10 etc ..."
                ])
            ->send();
        var_dump($data);*/

        $data2 = QueryBuilder::table('articles')
            ->select('articles.id as article_id', 'articles.title as article_title', 'articles.content as article_content', 'comments.id as comment_id', 'comments.title as comment_title', 'comments.comment as comment_comment')
            ->join('comments', 'articles.id', '=', 'comments.articles_id')
            ->send();

        var_dump($data2);

        /*$data3 = QueryBuilder::table('articles')
            ->update([
                'content' => 'my change lorem ipsum 2'
             ])->where('id', '=', 18)
            ->send();

        var_dump($data3);*/

        /*$data4 = QueryBuilder::table('articles')
            ->delete()
            ->where('id', '>=', '5')
            ->send();

        var_dump($data4);*/

        Router::get('/', function () {
            return 'hello';
        });
        // lance le router
        $response = Router::run();
        echo ($response);

    }
}