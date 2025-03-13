<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\GenderStatus;
use App\Enum\HeightStatus;
use App\Enum\MorphologyStatus;
use App\Enum\WeightStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        return $this->render('registration/register.html.twig', [
            'genders' => GenderStatus::cases(),
            'weights' => WeightStatus::cases(),
            'heights' => HeightStatus::cases(),
            'morphologies' => MorphologyStatus::cases(),
//            'roles' => RoleStatus::cases(),
        ]);
    }

    #[Route(path: '/saveUser', name: 'app_save_user')]
    public function saveUser(Request $request, UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $gender = $request->request->get('gender');
        $weight = $request->request->get('weight');
        $height = $request->request->get('height');
        $morphology = $request->request->get('morphology');
        $role = $request->request->get('Client');

        $app = new User();

        $app->setName($name);
        $app->setEmail($email);
        $app->setPassword($userPasswordHasher->hashPassword($app, $password));
        $app->setGender(GenderStatus::from($gender));
        $app->setWeight(WeightStatus::tryFrom("W" . $weight));
        $app->setHeight(HeightStatus::tryFrom("H" . $height));
        $app->setMorphology(MorphologyStatus::from($morphology));
        $app->setRoles((array)$role);
//        dd($app);

        try {
            $entityManager->persist($app);
            $entityManager->flush();

//            $mail = (new Email())
//                ->from('tatibatchi15@gmail.com')
//                ->to('tatibatchi15@hotmail.com')
//                ->subject('Test Email')
//                ->text('This is a test email.');
//
//            $mailer->send($mail);

//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $app,
//                (new TemplatedEmail())
//                    ->from(new Address('tatibatchi15@gmail.com', 'noreply'))
//                    ->to((string) $app->getEmail())
//                    ->subject('Please Confirm your Email')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );
            $this->addFlash('success', "Bienvenu sur notre plateform");
            return $this->redirectToRoute('app_register');

        } catch (TransportExceptionInterface $e){
            $this->addFlash('error', "Il y'a un probleme");
            return $this->redirectToRoute('app_register');
        }
    }
}