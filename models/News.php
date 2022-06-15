<?php

namespace models;

use utils\DB;

class News
{
    public static function getOne($id)
    {
        $conn = DB::setupConnection();
        $result = $conn->query("SELECT *,CAST(FROM_UNIXTIME(`idate`) as date) as 'date' FROM news where id=$id");
        return $result->fetch(\PDO::FETCH_ASSOC);
    }

    public static function getAll()
    {

    }

    public static function getWithOffsetAndLimit(int $limit,int $offset){
        $conn = DB::setupConnection();
        $result = $conn->query("SELECT *,CAST(FROM_UNIXTIME(`idate`) as date) as 'date' FROM news ORDER BY `news`.`idate` DESC limit $limit OFFSET $offset");
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getAmountOfPages(int $limit): int
    {
        $conn = DB::setupConnection();
        $result = $conn->query("SELECT COUNT(*) as amount FROM news;");
        $amountOfNewsRes = $result->fetch(\PDO::FETCH_ASSOC);
        $amountOfNews = $amountOfNewsRes['amount'] ?? 1;
        return ceil($amountOfNews/$limit);
    }
}
