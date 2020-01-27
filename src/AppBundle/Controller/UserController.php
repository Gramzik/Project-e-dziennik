<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user_panel")
     */
    public function userPanelAction()
    {
        return $this->render(':UserViews:userPanel.html.twig');
    }

    /**
     * @Route("/educator", name="educator_panel")
     */
    public function educatorPanelAction()
    {
        return $this->render(':UserViews:educatorPanel.html.twig');
    }

    /**
     * @Route("/teacher", name="teacher_panel")
     */
    public function teacherPanelAction()
    {
        return $this->render(':UserViews:teacherPanel.html.twig');
    }

    /**
     * @Route("/admin", name="admin_panel")
     */
    public function adminPanelAction()
    {
        return $this->render(':UserViews:adminPanel.html.twig');
    }

    /**
     * @Route("/userInfo/{id}", name="show_user_info")
     */
    public function showUserInfoAction($id)
    {

    }

}
