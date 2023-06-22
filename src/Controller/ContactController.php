<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ContactController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $message = $request->request->get('message');
            
            if (empty($name) || empty($email) || empty($message)) {
                // Hiba! Kérjük töltsd ki az összes mezőt!
                $errorMessage = 'Hiba! Kérjük töltsd ki az összes mezőt!';
                $this->addFlash('error', $errorMessage);
            } else {
                // Minden mező helyesen van kitöltve
                $successMessage = 'Köszönjük szépen a kérdésedet. Válaszunkkal hamarosan keresünk a megadott e-mail címen.';
                $this->addFlash('success', $successMessage);

                // További feldolgozási lépések (pl. email küldése, adatbázisba mentés stb.)
                $entityManager = $this->entityManager;
                
                $contact = new Contact();
                $contact->setName($name);
                $contact->setEmail($email);
                $contact->setMessage($message);
                
                $entityManager->persist($contact);
                $entityManager->flush();
            }
        }
    
        // Render the contact form template
        return $this->render('contact/index.html.twig');
    }
}
