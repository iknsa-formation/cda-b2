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
use App\Service\GetUniqueId;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

#[AsCommand(
    name: 'app:user:run-gdpr',
    description: 'Add a short description for your command',
)]
class UserDeletePersonalDataCommand extends Command
{
    private $em;

    private $uniqueIdGenerator;

    public function __construct(EntityManagerInterface $em, GetUniqueId $uniqueIdGenerator)
    {
        parent::__construct();
        $this->em = $em;
        $this->uniqueIdGenerator = $uniqueIdGenerator;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $userRepository = $this->em->getRepository(User::class);

        $users = $userRepository->findBy(['isDeleted' => true]);

        foreach ($users as $user) {
            $user->setEmail($this->uniqueIdGenerator->getUniqueId() . '@deleted.com');
            $user->setPassword('deleted');

            $this->em->persist($user);
        }

        $this->em->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
