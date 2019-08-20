<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $security = $this->container->get('security.authorization_checker');

        if ($security->isGranted('IS_AUTHENTICATED_REMEMBERED') == false){
            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render('@FOSUser/layout.html.twig');
    }


}
