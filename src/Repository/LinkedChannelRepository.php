<?php

namespace PierreMiniggio\YoutubeToCMS\Repository;

use PierreMiniggio\DatabaseConnection\DatabaseConnection;

class LinkedChannelRepository
{
    public function __construct(private DatabaseConnection $connection)
    {}

    public function findAll(): array
    {
        $this->connection->start();
        $channels = $this->connection->query('
            SELECT
            wcyc.youtube_id as y_id,
                w.id as w_id,
                w.base_url,
                w.token
            FROM website_cms as w
            RIGHT JOIN website_cms_youtube_channel as wcyc
                ON w.id = wcyc.website_id
        ', []);
        $this->connection->stop();

        return $channels;
    }
}
