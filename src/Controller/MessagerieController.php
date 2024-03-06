<?php

namespace App\Controller;

use App\Entity\Messagerie;
use App\Entity\Messages;
use App\Form\MessagerieType;
use App\Form\MessagesType;
use App\Repository\MessagerieRepository;
use App\Notification\NotificationMailer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\ErrorCorrectionLevel;


class MessagerieController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * @Route("/messages", name="messages")
     */
    public function index(): Response
    {
        $user = $this->security->getUser();
        $receivedMessages = $this->entityManager->getRepository(Messagerie::class)->findBy(['recipient' => $user]);
        $sentMessages = $this->entityManager->getRepository(Messagerie::class)->findBy(['sender' => $user]);

        return $this->render('messagerie/index.html.twig', [
            'receivedMessages' => $receivedMessages,
            'sentMessages' => $sentMessages,
        ]);
    }

    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request): Response
    {
        $message = new Messagerie();
        $form = $this->createForm(MessagerieType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $this->entityManager->persist($message);
            $this->entityManager->flush();

            $this->addFlash("message", "Message envoyé avec succès.");
            return $this->redirectToRoute("messages");
        }

        return $this->render("messagerie/send.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        $user = $this->security->getUser();
        $messages = $this->entityManager->getRepository(Messagerie::class)->findBy(['recipient' => $user]);

        return $this->render('messagerie/received.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/sent", name="sent")
     */
    public function sent(): Response
    {
        $user = $this->security->getUser();
        $messages = $this->entityManager->getRepository(Messagerie::class)->findBy(['sender' => $user]);

        return $this->render('messagerie/sent.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Messagerie $message): Response
    {
        $message->setIsRead(true);
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $this->render('messagerie/read.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(MessagerieRepository $messagerieRepository, ManagerRegistry $managerRegistry,$id): Response
    {

        $m=$managerRegistry->getManager();
        $findid=$messagerieRepository->find($id);
        $m->remove($findid);
        $this->entityManager->flush();

        return $this->redirectToRoute("received");
    }



    
}