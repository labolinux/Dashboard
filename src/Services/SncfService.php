<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 17/01/2018
 * Time: 22:04
 */

namespace App\Services;


use App\Entity\Gare;
use App\Storage;
use Doctrine\Common\Persistence\ObjectManager;
use GuzzleHttp\Client;

class SncfService
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * SncfService constructor.
     *
     * @param Client $client
     * @param Storage $storage
     * @param ObjectManager $manager
     */
    public function __construct(Client $client, Storage $storage, ObjectManager $manager)
    {
        $this->client = $client;
        $this->storage = $storage;
        $this->manager = $manager;
    }

    /**
     * @param array $code
     *
     * @return mixed
     */
    public function getNextTrains($code)
    {
        $url = "/gare/" . $code . "/depart/";
        $data = $this->getFromCache($url, "sncf.next_transilien");

        return $data;
    }

    /**
     * @param \SimpleXMLElement $element
     *
     * @return array
     */
    public function processXmltrains(\SimpleXMLElement $element)
    {
        $trains =  [];
        foreach ($element->{'train'} as $train) {
            $terminus = $this->findTerminus((string) $train->{'term'});
            $etat = ("Supprimé" == (string) $train->{'etat'}) ? (string) $train->{'etat'} : "A l'heure";
            $trains[] = [
                'date' =>   (string) $train->{'date'},
                'num' =>    (string) $train->{'num'},
                'miss' =>   (string) $train->{'miss'},
                'terminus' => (null !== $terminus) ? $terminus->getRealName() : "Gare N'existe pas",
                'etat' => $etat,
            ];
        }

        return $trains;
    }

    /**
     * @param $uic
     *
     * @return Gare|null|object
     */
    public function findTerminus($uic)
    {
        return $this->manager->getRepository(Gare::class)->findOneBy([
            'uic' => $uic
        ]);
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    private function request($url)
    {
        $data = $this->client->get($url, [
            'headers' => [
                'Accept' => 'application/vnd.sncf.transilien.od.depart+xml;vers=1'
            ]
        ]);
        $response = simplexml_load_string($data->getBody());

        return $this->processXmltrains($response);
    }

    /**
     * @param $url
     * @param $key
     *∞
     * @return mixed
     */
    private function getFromCache($url, $key)
    {
        $cache = $this->storage->getItem($key);

        if ($cache->isHit()) {
            $data = unserialize($cache->get());
        } else {
            $data = $this->request($url);
            $this->storage->setItem($cache, $data);
        }
        return $data;
    }
}