<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends Controller
{
    /**
     * @Route("/admin/promoteTeacher/", name="show_teachers_to_promote")
     */
    public function showTeachersToPromote()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $qb = $repo->createQueryBuilder('u');
        $qb->select('u')
            ->where('u.roles NOT LIKE :role1')
            ->andWhere('u.roles NOT LIKE :role2')
            ->setParameters(['role1' => '%ROLE_EDUCATOR%',
                'role2' => '%ROLE_TEACHER%']);

        $users = $qb->getQuery()->getResult();

        return $this->render(':TeacherViews:showTeachersToPromote.html.twig', ['users' => $users]);
    }

    /**
     *
     * @Route("/admin/newTeacher/{id}", name="new_teacher")
     */
    public function promoteTeacherAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $educator = $repo->find($id);
        $educator->setRoles(['ROLE_TEACHER']);
        $em->persist($educator);
        $em->flush();

        $this->addFlash('notice', 'Mianowano nowego nauczyciela.');

        return $this->redirectToRoute('show_teachers_to_promote');
    }

    /**
     * @Route("/showTeachers", name="show_teachers")
     */
    public function showAllTeachers()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $qb = $repo->createQueryBuilder('u');
        $qb->select('u')
            ->where('u.roles LIKE :role1')
            ->orWhere('u.roles LIKE :role2')
            ->setParameters(['role1' => '%ROLE_TEACHER%',
                'role2' => '%ROLE_EDUCATOR%'
            ]);

        $teachers = $qb->getQuery()->getResult();

        return $this->render(':TeacherViews:showAllTeachers.html.twig', ['teachers' => $teachers]);
    }

}
