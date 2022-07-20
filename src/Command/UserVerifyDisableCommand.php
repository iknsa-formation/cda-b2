<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


#[AsCommand(
    name: 'app:user:disable-if-deleted',
    description: 'Add a short description for your command',
)]
class UserVerifyDisableCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $userRepository = $this->em->getRepository(User::class);

        $users = $userRepository->findBy(['isDeleted' => true, 'isActive' => true]);
        
        foreach ($users as $user) {
            $user->setIsActive(false);

            $this->em->persist($user);
        }

        $this->em->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
