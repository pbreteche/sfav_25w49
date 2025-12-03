<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:hello-world',
    description: 'First training command.',
)]
class HelloWorldCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('subject', InputArgument::OPTIONAL, 'To who to say "hello".', 'world')
            ->addOption('lang', 'l', InputOption::VALUE_REQUIRED, 'Choose your language', ['en', 'fr', 'es'])
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $subject = $input->getArgument('subject');

        if ($output->isDebug()) {
            $io->info('argument is subject='.$subject);
        }

        switch ($input->getOption('lang')) {
            case 'es':
                $io->title(sprintf('¡Holla %s!', $subject));
                break;
            case 'fr':
                $io->title(sprintf('Bonjour %s !', $subject));
                break;
            default:
                $io->title(sprintf('Hello %s!', $subject));
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
