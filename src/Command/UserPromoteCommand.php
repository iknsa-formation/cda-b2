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

        // // Retrieve all roles of the user
        // // Remove the "ROLE_USER" from the list

        // Add the new role to the list

        // Persits the user




        // $user->addRole()





        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }


        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        // $io->error("Ooops error");
        // $io->warning("Ooops Warning");
        // $io->info("Pour info....");

        return Command::SUCCESS;
    }
}
