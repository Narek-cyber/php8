<?php

namespace Wfm;

class Cache
{
    use TSingleton;

    /**
     * @param $key
     * @param $data
     * @param int $seconds
     * @return bool
     */
    public function set($key, $data, int $seconds = 3600): bool
    {
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;

        if (!is_dir(CACHE)) {
            mkdir(CACHE, 0755, true);
        }

        if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $key
     * @return false|mixed
     */
    public function get($key): mixed
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            unlink($file);
        }
        return false;
    }

    /**
     * @param $key
     * @return void
     */
    public function delete($key): void
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            unlink($file);
        }
    }
}