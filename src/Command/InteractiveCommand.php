<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\TagRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:interactive',
    description: 'Show different interactions'
)]
class InteractiveCommand extends Command
{
    public function __construct(
        private TagRepository $tagRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $question = new Question('Sélectionner un tag');
        $question->setAutocompleterCallback(fn (string $value) => $this->tagRepository->findNamesStartingBy($value));
        $tagName = $io->askQuestion($question);

        $io->text('choix du tag:'.$tagName);

        // Valeur par défaut
        $question = new Question('votre plat préféré', 'pizza');
        $recipe = $io->askQuestion($question);
        $io->text($recipe);

        $question = new ConfirmationQuestion('Souhaitez continuer ?');
        $continue = $io->askQuestion($question);
        if (!$continue) {
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
