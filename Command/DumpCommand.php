<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Command;

use HoPeter1018\PresignedFilemanagerBundle\Services\Manager\ManagerRegistry;
use HoPeter1018\PresignedFilemanagerBundle\Services\Signer\SignerRegistry;
use Symfony\Component\Console\Command\Command;
// use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DumpCommand extends Command
{
    /** @var SignerRegistry */
    protected $signerRegistry;

    /** @var ManagerRegistry */
    protected $managerRegistry;

    public function __construct(SignerRegistry $signerRegistry, ManagerRegistry $managerRegistry)
    {
        $this->signerRegistry = $signerRegistry;
        $this->managerRegistry = $managerRegistry;

        parent::__construct();
    }

    protected function configure()
    {
        $this
          ->setName('hopeter1018:presigned-filemanager:dump')
          ->setDescription('Dump environment')
          ->setHelp('This command is to Dump environment')
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('[hopeter1018] ');

        // dump($this->signerRegistry->getAll());
        // foreach ($this->signerRegistry->getAll() as $key => $signer) {
        //     dump($key);
        //     dump($signer->signPost([]));
        // }
        foreach ($this->managerRegistry->getAll() as $key => $manager) {
            dump($key);
            dump($manager);
        }

        $io->success('Done');
    }
}
