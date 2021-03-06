<?php
// src/Controller/PageController.php
namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PageController extends AbstractController
{

    /**
     * @Route("", name="home")
     */
    public function index(): Response
    {

        return $this->render('page/index.html.twig');
    }

    /**
     * @Route("/privacy", name="privacy")
     */
    public function privacy(): Response
    {

        return $this->render('page/privacy.html.twig');
    }

    /**
     * @Route("/gestes", name="gestes")
     */
    public function gestes(): Response
    {

        return $this->render('page/gestes.html.twig');
    }
    /**
     * @Route("/offres", name="offres")
     */
    public function offres(): Response
    {

        return $this->render('page/offres.html.twig');
    }

    /**
     * @Route("/a-propos", name="about")
     */
    public function about(): Response
    {

        return $this->render('page/about.html.twig');
    }

    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function portfolio(): Response
    {

        return $this->render('page/portfolio.html.twig');
    }

    /**
     * @Route("/contact_success", name="contact_success")
     */
    public function contact_success(): Response
    {

        return $this->render('page/contact_success.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        // $contact = new Contact();
        // $contact->setDate(new \DateTime('now'));
        // $contact->setEmail("isaac.for.strass@gmail.com");

        //$form = $this->createForm(ContactType::class, $contact);

        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('content', TextareaType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$contact` variable has also been updated
            $contact = $form->getData();

            $now = new \DateTime('now');

            $email = (new Email())
            ->from(new Address('contact@webaccess.ci', 'Web Access Ci'))
            ->to('webaccessci@gmail.com')
            ->subject('[WebAccessCi] Demande de contact '.$form->get("name")->getData())
            ->text($form->get("name")->getData().'vous a contact?? le '.$now->format('d-m-Y').'\n En indiquant:\n'.$form->get("content")->getData()."\n email: ".$form->get("email")->getData());

        	$mailer->send($email);

        	$email2 = (new Email())
            ->from(new Address('contact@webaccess.ci', 'Web Access Ci'))
            ->to($form->get("email")->getData())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('WebAccess CI - Votre Demande ?? ??t?? prise en compte')
            ->text('Votre Demande ?? ??t?? prise en compte, nous vous contacterons sous peu')
            ->html('<h1>Message envoy??</h1><p>Le formulaire nous a ??t?? envoy?? et nous vous contacterons sous peu</p></br><p>Cordialement,</p><h2>Web Access CI</h2>');

        	$mailer->send($email2);

            return $this->redirectToRoute('contact_success');
        }

         return $this->render('page/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
