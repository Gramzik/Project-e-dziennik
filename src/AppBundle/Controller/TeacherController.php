<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Teacher;
use AppBundle\Entity\User;
use AppBundle\Form\NewTeacherType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TeacherController extends Controller
{
    /**
     * @Route("/admin/newTeacher", name="new_teacher")
     */
    public function promoteTeacherAction(Request $request)
    {
        $teacher = new Teacher();

        $form = $this->createForm(NewTeacherType::class);
        $form->handleRequest($request);

        //check if form was submitted
        if ($form->isSubmitted() && $form->isValid()) {
            $teacher = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);

            $teacherId = $teacher->getUser();

            $repo = $em->getRepository('AppBundle:User');
            $user = $repo->find($teacherId);
            $user->setRoles(['ROLE_TEACHER']);
            $em->flush();

            return $this->redirectToRoute('show_teachers');
        }
        //if not show form with twig
        return $this->render('TeacherViews/newTeacherForm.html.twig', ['form' => $form->createView()]);
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
            ->andWhere('u.roles LIKE :role2')
            ->setParameters(['role1' => '%ROLE_TEACHER%',
                'role2' => '%ROLE_EDUCATOR%'
                ]);

        $teachers = $qb->getQuery()->getResult();

        return $this->render(':TeacherViews:showAllTeachers.html.twig', ['teachers' => $teachers]);
    }

    /**
     * @Route("/teacherInfo/{id}", name="teacher_info")
     */
    public function showTeacherAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $teacher = $repo->find($id);

        return $this->render(':TeacherViews:showTeacher.html.twig', ['teacher' => $teacher]);
    }

    /**
     * @Route("/teacherLessons/{id}", name="show_teacher_lessons")
     */
    public function teacherLessonsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $teacher = $repo->find($id);
        $lessons = $teacher->getLesson();


        return $this->render(':TeacherViews:showTeacherLessons.html.twig', ['teacher' => $teacher, 'lessons' => $lessons]);
    }
}
