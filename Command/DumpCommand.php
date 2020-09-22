<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Command;

use HoPeter1018\PresignedFilemanagerBundle\Services\Manager\ManagerRegistry;
use HoPeter1018\PresignedFilemanagerBundle\Services\Signer\SignerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
// use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DumpCommand extends Command
{
    /** @var SignerRegistry */
    protected $signerRegistry;

    /** @var ManagerRegistry */
    protected $managerRegistry;

    /** @var UrlGeneratorInterface */
    protected $router;

    public function __construct(SignerRegistry $signerRegistry, ManagerRegistry $managerRegistry, UrlGeneratorInterface $router)
    {
        $this->signerRegistry = $signerRegistry;
        $this->managerRegistry = $managerRegistry;
        $this->router = $router;

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

        $request = new Request(
          ['_GET' => 1],
          ['_POST' => 2, 'public' => false, 'uploadPathPrefix' => 'abc'],
          [],
          ['_COOKIE' => 3],
          [],
          ['_SERVER' => 3]
        );
        dump($request->isMethod('GET'));
        dump($request->request->all());

        dump($this->router->generate('hopeter1018_presigned_filemanager_get_presigned_url', [
          'manager' => 'aws_s3_service',
        ]));
        // dump($this->signerRegistry->getAll());
        // foreach ($this->signerRegistry->getAll() as $key => $signer) {
        //     dump($key);
        //     dump($signer->signPost([]));
        // }
        foreach ($this->managerRegistry->getAll() as $key => $manager) {
            dump($key);
            dump($manager->sanitizeList($request->request->all()));
            dump($manager->list($request->request->all()));
            dump($manager->sanitizeRemove($request->request->all()));
            dump($manager->remove($request->request->all()));
            dump($manager->sanitizePresign(false, $request->request->all()));
            dump($manager->presign(false, $request->request->all()));
            dump($manager->sanitizeUploaded($request->request->all()));
            dump($manager->uploaded($request->request->all()));
        }

        $io->success('Done');
    }
}
