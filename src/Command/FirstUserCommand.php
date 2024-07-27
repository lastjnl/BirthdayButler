<?php

// src/Command/HashPasswordCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'app:first-user')]
class FirstUserCommand extends Command
{
    // Define a valid command name
    protected static $defaultName = 'app:first-user';

    private $passwordHasher;
    private $em;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em)
    {
        $this->passwordHasher = $passwordHasher;
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Hashes a password.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password to hash')
            ->addArgument('email', InputArgument::REQUIRED, 'Email is required');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $user = new User();
        $user->setEmail('joslast96@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);

        $plaintextPassword = 'testjos01';


        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);


        $password = $input->getArgument('password');
        $email = $input->getArgument('email');
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);

        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN']);

        $this->em->persist($user);
        $this->em->flush();

        return Command::SUCCESS;
    }
}