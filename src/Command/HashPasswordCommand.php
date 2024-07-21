<?php

// src/Command/HashPasswordCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'app:hash-password')]
class HashPasswordCommand extends Command
{
    // Define a valid command name
    protected static $defaultName = 'app:hash-password';

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Hashes a password.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password to hash');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $password = $input->getArgument('password');
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);

        $output->writeln('Hashed password: ' . $hashedPassword);

        return Command::SUCCESS;
    }
}