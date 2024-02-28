<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fake-users',
    description: 'Generate fake users',
)]
class FakeUsersCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setName('app:fake-users')
            ->setDescription('Generate fake users');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 300; $i++) {
            $user = new \App\Entity\User();
            $user->setUsername($faker->word);
            $user->setEmail($faker->email);

            // Generate a hashed password using password_hash
            $plainPassword = $faker->password;
            $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();

        $io->success('Fake users generated successfully.');

        return Command::SUCCESS;
    }

}