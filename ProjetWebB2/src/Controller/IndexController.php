<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

      /**
   * @Route("/inscription", name="inscription")
   */
  public function inscription(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
  {

    $user = new User();

    $form = $this->createForm(UserType::class, $user);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $form->get('password')->getData()

            )
        );
      $em->persist($user);
      $em->flush();

      return $this->redirectToRoute('app_login');
    }

    return $this->render('index/inscription.html.twig', [
      'form' => $form->createView()
    ]);
  }

/**
 * Redirect users after login based on the granted ROLE
 * @Route("/login/redirect", name="_login_redirect")
 */
public function loginRedirectAction(Request $request)
{
    if($this->isGranted('ROLE_ADMIN'))
    {
        return $this->redirectToRoute('admin_dashboard');
    }
    else if($this->isGranted('ROLE_RESTAURATEUR'))
    {
        return $this->redirectToRoute('restaurateur');
    }
    else
    {
        return $this->redirectToRoute('client');
    }
}

}
