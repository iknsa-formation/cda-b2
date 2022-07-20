<?php

namespace App\Command;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'user:promote',
    description: 'Add a short description for your command',
)]
class UserPromoteCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;

        parent::__construct();
    }
    
    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('role', InputArgument::REQUIRED, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $role = $input->getArgument('role');

        // Get EntityManager
        
        // A. Access repositories
        $repo = $this->em->getRepository(User::class);

        // B. Get the user at $email
        $user = $repo->findOneBy([
            'email' => $email
        ]);

        if (!$user)
        {
            $io->error(sprintf("No user found with the email %s", $email));
            return Command::FAILURE;
        }

        // Add the new role to the list
        $user->addRole( $role );

        // Persits the user
        $this->em->persist($user);
        $this->em->flush();

        $io->success(sprintf('The user %s as the new role %s', $email, $role));

        return Command::SUCCESS;
    }
}


/**
 * @info pour les cron vous pouvez les lancer toutes les minutes
 * @todo set is_active = 0 where is_deleted = 1
 * @todo supprimer les données personnelles de tous les users is_deleted=1
 */