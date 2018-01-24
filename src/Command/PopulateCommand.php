<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 22/01/2018
 * Time: 21:36
 */

namespace App\Command;


use App\Entity\Gare;
use App\Kernel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PopulateCommand extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('populate:gare')
            ->setDescription('Populate Gare')
            ->setHelp('This command allows you to create a user...')

        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Kernel $kernel */
        $kernel = $this->getApplication()->getKernel();

        $file = $kernel->getRootDir() . '/../data/sncf-gares-et-arrets-transilien-ile-de-france.json';
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        $progress = new ProgressBar($output, count($data));
        $doctrine = $kernel->getContainer()->get('doctrine')->getManager();
        $progress->start();
        foreach ($data as $item) {
            $gare = new Gare();
            $gare->setUic($item['fields']['code_uic']);
            $gare->setRealName($item['fields']['nom_gare']);
            $gare->setSlug($this->slugify($item['fields']['libelle']));
            $gare->setArret(ucfirst($item['fields']['libelle_point_d_arret']));
            $gare->setZone((int)$item['fields']['zone_navigo']);
            $doctrine->persist($gare);
            $progress->advance();
        }
        $doctrine->flush();
        $progress->finish();
    }


    function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}