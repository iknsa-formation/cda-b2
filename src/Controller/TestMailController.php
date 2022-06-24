<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestMailController extends AbstractController
{
    #[Route('/test/mail', name: 'app_test_mail')]
    public function index(MailerInterface $mailer, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->find(1);

        $books = $author->getBooks();


        $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            // ->text('Sending emails is fun again!')
            // ->html('<p>See Twig integration for better HTML integration </p>');
            ->textTemplate('email/test/message.txt.twig')
            ->htmlTemplate('email/test/message.html.twig')
            ->context([
                'sitename' => 'My Book Store',
                'books' => $books
            ])
        
        ;


        $mailer->send($email);

        return $this->render('test_mail/index.html.twig', [
            'controller_name' => 'TestMailController',
        ]);
    }
}
