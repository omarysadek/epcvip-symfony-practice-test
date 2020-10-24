<?php

namespace App\Component\Handler;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\AbstractProcessingHandler;
use App\Repository\LogRepository;

class MonologDBHandler extends AbstractProcessingHandler
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function write(array $record)
    {
        $this->em->persist($record['context']['log']);
        $this->em->flush();
    }
}