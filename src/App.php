<?php

namespace PierreMiniggio\YoutubeToCMS;

use PierreMiniggio\YoutubeToCMS\Connection\DatabaseConnectionFactory;
use PierreMiniggio\YoutubeToCMS\Repository\LinkedChannelRepository;
use PierreMiniggio\YoutubeToCMS\Repository\NonUploadedVideoRepository;
use PierreMiniggio\YoutubeToCMS\Repository\VideoToUploadRepository;

class App
{
    public function run(): int
    {
        $code = 0;

        $config = require(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php');

        if (empty($config['db'])) {
            echo 'No DB config';

            return $code;
        }

        $databaseConnection = (new DatabaseConnectionFactory())->makeFromConfig($config['db']);
        $channelRepository = new LinkedChannelRepository($databaseConnection);
        $nonUploadedVideoRepository = new NonUploadedVideoRepository($databaseConnection);
        $videoToUploadRepository = new VideoToUploadRepository($databaseConnection);

        $linkedChannels = $channelRepository->findAll();

        if (! $linkedChannels) {
            echo 'No linked channels';

            return $code;
        }

        foreach ($linkedChannels as $linkedChannel) {
            echo PHP_EOL . PHP_EOL . 'Checking website ' . $linkedChannel['base_url'] . '...';

            $postsToPost = $nonUploadedVideoRepository->findByWebsiteAndYoutubeChannelIds($linkedChannel['w_id'], $linkedChannel['y_id']);
            echo PHP_EOL . count($postsToPost) . ' post(s) to post :' . PHP_EOL;
            
            foreach ($postsToPost as $postToPost) {
                echo PHP_EOL . 'Posting ' . $postToPost['title'] . ' ...';

                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $linkedChannel['base_url'] . '/api/posts/from-youtube',
                    CURLOPT_POST => 1,
                    CURLOPT_POSTFIELDS => json_encode([
                        'title' => $postToPost['title'],
                        'url' => $postToPost['url'],
                        'thumbnail' => $postToPost['thumbnail'],
                        'description' => $postToPost['description']
                    ])
                ]);
                $authorization = "Authorization: Bearer " . $linkedChannel['token'];
                curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $authorization]);

                $curlResult = curl_exec($curl);
                $res = json_decode($curlResult, true);

                if (isset($res['id'])) {
                    $videoToUploadRepository->insertVideoIfNeeded($res['id'], $linkedChannel['w_id'], $postToPost['id']);
                    echo PHP_EOL . $postToPost['title'] . ' posted !';
                } else {
                    echo PHP_EOL . 'Error while posting ' . $postToPost['title'] . ':' . $curlResult;
                }
            }

            echo PHP_EOL . PHP_EOL . 'Done for website ' . $linkedChannel['base_url'] . ' !';
        }

        return $code;
    }
}
