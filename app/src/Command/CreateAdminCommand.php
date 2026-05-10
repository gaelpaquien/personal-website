<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Create a new admin user with ROLE_ADMIN.'
)]
class CreateAdminCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $io->title('Création d\'un compte admin');

        $email = $io->ask('Email', null, function (?string $value) {
            if (!$value || !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('Email invalide.');
            }
            return $value;
        });

        if ($this->userRepository->findOneBy(['email' => $email])) {
            $io->error(sprintf('Un compte avec l\'email "%s" existe déjà.', $email));
            return Command::FAILURE;
        }

        $firstname = $io->ask('Prénom', null, function (?string $value) {
            if (!$value) {
                throw new \RuntimeException('Prénom requis.');
            }
            return $value;
        });

        $lastname = $io->ask('Nom', null, function (?string $value) {
            if (!$value) {
                throw new \RuntimeException('Nom requis.');
            }
            return $value;
        });

        $passwordQuestion = new Question('Mot de passe (min. 8 caractères) : ');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $passwordQuestion->setValidator(function (?string $value) {
            if (!$value || strlen($value) < 8) {
                throw new \RuntimeException('Le mot de passe doit faire au moins 8 caractères.');
            }
            return $value;
        });

        $password = $helper->ask($input, $output, $passwordQuestion);

        $user = new User();
        $user
            ->setEmail($email)
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success(sprintf('Compte admin créé pour %s.', $email));

        return Command::SUCCESS;
    }
}
