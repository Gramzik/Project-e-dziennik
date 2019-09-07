<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EducatorController extends Controller
{
    /**
     * @Route("/admin/promoteEducator/", name="show_educators_to_promote")
     */
    public function showEducatorsToPromote()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $qb = $repo->createQueryBuilder('u');
        $qb->select('u')
            ->where('u.roles NOT LIKE :role')
            ->setParameter('role', '%ROLE_EDUCATOR%');

        $users = $qb->getQuery()->getResult();

        return $this->render(':EducatorViews:showEducatorsToPromote.html.twig', ['users'=>$users]);
    }

    /**
     * @Route("/admin/newEducator/{id}", name="new_educator")
     */
    public function promoteEducatorAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $educator = $repo->find($id);
        $educator->setRole('ROLE_EDUCATOR');
    }

    /**
     * @Route("/showEducators", name="show_educators")
     */
    public function showAllEducatorsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $qb = $repo->createQueryBuilder('u');
        $qb->select('u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%ROLE_EDUCATOR%');

        $educators = $qb->getQuery()->getResult();

        return $this->render(':EducatorViews:showAllEducators.html.twig', ['educators' => $educators]);
    }

    /**
     * @Route("/educatorInfo/{id}", name="educator_info")
     */
    public function showEducatorAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $educator = $repo->find($id);


        return $this->render(':EducatorViews:showEducator.html.twig', ['educator' => $educator]);
        //TODO
    }


}
