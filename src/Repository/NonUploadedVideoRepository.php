<?php

namespace PierreMiniggio\YoutubeToCMS\Repository;

use PierreMiniggio\DatabaseConnection\DatabaseConnection;

class NonUploadedVideoRepository
{
    public function __construct(private DatabaseConnection $connection)
    {}

    public function findByWebsiteAndYoutubeChannelIds(int $websiteCMSId, int $youtubeChannelId): array
    {
        $this->connection->start();

        $postedWebsitePostIds = $this->connection->query('
            SELECT w.id
            FROM website_post as w
            RIGHT JOIN website_post_youtube_video as wpyt
            ON w.id = wpyt.website_id
            WHERE w.website_id = :website_id
        ', ['website_id' => $websiteCMSId]);
        $postedWebsitePostIds = array_map(fn ($entry) => (int) $entry['id'], $postedWebsitePostIds);

        $postsToPost = $this->connection->query('
            SELECT
                y.id,
                y.title,
                y.url,
                y.thumbnail,
                y.description
            FROM youtube_video as y
            ' . (
                $postedWebsitePostIds
                    ? 'LEFT JOIN website_post_youtube_video as wpyt
                    ON y.id = wpyt.youtube_id
                    AND wpyt.website_id IN (' . implode(', ', $postedWebsitePostIds) . ')'
                    : ''
            ) . '
            
            WHERE y.channel_id = :channel_id
            ' . ($postedWebsitePostIds ? 'AND wpyt.id IS NULL' : '') . '
            ;
        ', [
            'channel_id' => $youtubeChannelId
        ]);
        $this->connection->stop();

        return $postsToPost;
    }
}
