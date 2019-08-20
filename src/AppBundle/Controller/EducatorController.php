<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Educator;
use AppBundle\Entity\User;
use AppBundle\Form\NewEducatorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EducatorController extends Controller
{
    /**
     * @Route("/admin/newEducator", name="new_educator")
     */
    public function promoteEducatorAction(Request $request)
    {
        $educator = new Educator();

        $form = $this->createForm(NewEducatorType::class, $educator);
        $form->handleRequest($request);

        //check if form was submitted
        if ($form->isSubmitted() && $form->isValid()) {
            $educator = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($educator);

            $educatorId = $educator->getUser();

            $repo = $em->getRepository(User::class);
            $user = $repo->find($educatorId);
            $user->setRoles(['ROLE_EDUCATOR']);
            $em->flush();

            return $this->redirectToRoute('show_educators');
        }
        //if not show form with twig
        return $this->render(':EducatorViews:newEducatorForm.html.twig', ['form' => $form->createView()]);
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
