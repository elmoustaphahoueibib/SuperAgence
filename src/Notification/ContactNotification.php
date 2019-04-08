<?php

namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification {


    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */

    public function __construct(\Swift_Mailer $mailer)
    {

        $this->mailer = $mailer;
    }

    /**
     * @param Contact $contact
     */
    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Agence: ' . $contact->getProperty()->getTitle()))
            ->setFrom('noreply@agence.mr')
            ->setTo('contact@agence.mr')
            ->setBody(
                $this->get('mjml')->render(
                    $this->get('twig')->render('email/example.mjml.twig', [
                        'contact' => $contact
                    ])
                ),
                'text/html'
            )
        ;

        $this->get('mailer')->send($message);
    }
}