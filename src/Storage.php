<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 17/01/2018
 * Time: 22:35
 */

namespace App;


use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;

class Storage
{

    /**
     * @var AdapterInterface
     */
    private $cache;

    public function __construct(AdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    public function setItem(CacheItem $item, $data)
    {
        $item->set(serialize($data));
        $item->expiresAt(new \DateTime('+1 minute'));
        $this->cache->save($item);
    }

    public function getItem($key)
    {
        return $this->cache->getItem($key);
    }
}