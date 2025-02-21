<?php

class WordFrequencyModel
{
    private static $redis;

    const REDIS_HOST = 'redis';
    const REDIS_PORT = 6379;

    /**
     * Load word frequencies from Redis
     *
     * @return array
     */
    public static function load(): array
    {
        self::initRedis();

        $keys = self::$redis->keys('word_freq:*');
        $wordFrequency = [];

        foreach ($keys as $key) {
            $word = str_replace('word_freq:', '', $key);
            $count = self::$redis->get($key);
            $wordFrequency[$word] = (int)$count;
        }

        return $wordFrequency;
    }

    /**
     * Save word frequencies to Redis
     *
     * @param array $wordFrequency
     * @return void
     */
    public static function save(array $wordFrequency): void
    {
        self::initRedis();

        foreach ($wordFrequency as $word => $count) {
            self::$redis->set('word_freq:' . $word, $count);
        }
    }

    /**
     * Initialize Redis connection
     */
    private static function initRedis()
    {
        if (!self::$redis) {
            self::$redis = new Redis();
            self::$redis->connect(self::REDIS_HOST, self::REDIS_PORT);
        }
    }
}
