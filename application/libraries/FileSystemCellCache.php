<?php
/**
 * FileSystemCellCache
 *
 * A minimal PSR-16 (Psr\SimpleCache\CacheInterface) implementation that
 * stores PhpSpreadsheet's cell data on disk instead of keeping every
 * cell object in PHP memory.
 *
 * Why this is needed:
 * PhpSpreadsheet's default cache (Collection\Memory) keeps every single
 * cell in a PHP array in RAM. With large reports (thousands of rows x
 * dozens of columns), that adds up to hundreds of thousands of objects
 * in memory before a single byte of the xlsx file is written, which is
 * what causes "Allowed memory size exhausted" errors.
 *
 * This class persists each cell's serialized data to a temp file instead,
 * and only loads it back into memory when PhpSpreadsheet actually reads
 * that specific cell. This trades a bit of disk I/O for a large drop in
 * peak memory usage.
 *
 * No new Composer dependency is required — this only relies on
 * psr/simple-cache, which is already vendored alongside PhpSpreadsheet.
 *
 * Usage (place this BEFORE creating any Spreadsheet object):
 *
 *   require_once APPPATH . 'libraries/FileSystemCellCache.php';
 *   \PhpOffice\PhpSpreadsheet\Settings::setCache(new FileSystemCellCache());
 *
 * Suggested location: application/libraries/FileSystemCellCache.php
 */

use Psr\SimpleCache\CacheInterface;

class FileSystemCellCache implements CacheInterface
{
    /**
     * Directory where cell cache files are stored for the current request.
     */
    private string $cacheDir;

    public function __construct()
    {
        $this->cacheDir = rtrim(sys_get_temp_dir(), '/') . '/phpspreadsheet_cache_' . uniqid('', true);

        if (!is_dir($this->cacheDir))
        {
            mkdir($this->cacheDir, 0700, true);
        }
    }

    /**
     * Cleans up all cache files when the object is destroyed (end of request,
     * or when PhpSpreadsheet swaps the cache implementation).
     */
    public function __destruct()
    {
        $this->clear();

        if (is_dir($this->cacheDir))
        {
            @rmdir($this->cacheDir);
        }
    }

    public function get($key, $default = null)
    {
        $path = $this->_pathFor($key);

        if (!file_exists($path))
        {
            return $default;
        }

        $contents = file_get_contents($path);
        if ($contents === false)
        {
            return $default;
        }

        return unserialize($contents);
    }

    public function set($key, $value, $ttl = null)
    {
        $path = $this->_pathFor($key);
        return file_put_contents($path, serialize($value)) !== false;
    }

    public function delete($key)
    {
        $path = $this->_pathFor($key);

        if (file_exists($path))
        {
            return unlink($path);
        }

        return true;
    }

    public function clear()
    {
        $files = glob($this->cacheDir . '/*.cache');

        if ($files === false)
        {
            return true;
        }

        foreach ($files as $file)
        {
            @unlink($file);
        }

        return true;
    }

    public function getMultiple($keys, $default = null)
    {
        $results = [];
        foreach ($keys as $key)
        {
            $results[$key] = $this->get($key, $default);
        }
        return $results;
    }

    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value)
        {
            $this->set($key, $value);
        }
        return true;
    }

    public function deleteMultiple($keys)
    {
        foreach ($keys as $key)
        {
            $this->delete($key);
        }
        return true;
    }

    public function has($key)
    {
        return file_exists($this->_pathFor($key));
    }

    /**
     * Builds a safe filesystem path for a given cache key.
     *
     * @param string $key
     * @return string
     */
    private function _pathFor(string $key) : string
    {
        // Cell cache keys from PhpSpreadsheet look like "A1", "B2", etc.
        // We hash them to avoid any filesystem-unsafe characters and to
        // keep filenames short and consistent.
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }
}