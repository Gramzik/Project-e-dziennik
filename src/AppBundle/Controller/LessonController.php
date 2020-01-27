<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classes;
use AppBundle\Entity\Grade;
use AppBundle\Entity\Lesson;
use AppBundle\Entity\User;
use AppBundle\Form\AddLessonType;
use AppBundle\Form\AddNewGradeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class LessonController extends Controller
{
    /**
     * @Route("/educator/newLesson/{classId}", name="new_lesson")
     */
    public function addNewLessonAction(Request $request, $classId)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $userId = $user->getId();

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Classes::class);

        $class = $repo->find($classId);

        $lesson = new Lesson();

        $form = $this->createForm(AddLessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lesson = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $lesson->setClass($class);
            $em->persist($lesson);
            $em->flush();
            return $this->redirectToRoute('class_info', ['id' => $classId]);
        }
        return $this->render('UserViews/FormView.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/lessonInfo/{id}", name="lesson_inf")
     */
    public function lessonInfoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Lesson::class);

        $lesson = $repo->find($id);
        $lessonId = $lesson->getId();
        $teacher = $lesson->getTeacher();
        $class = $lesson->getClass();
        $pupils = $class->getPupil();


        return $this->render(':LessonsViews:showLesson.html.twig', ['lesson' => $lesson, 'teacher' => $teacher, 'class' => $class, 'pupils' => $pupils]);
    }

    /**
     * @Route("/teacher/newGrade/{lessonId}/{userId}", name="new_grade")
     */
    public function newGradeAction(Request $request, $lessonId, $userId)
    {
        $em = $this->getDoctrine()->getManager();
        $repoLesson = $em->getRepository(Lesson::class);
        $repoUser = $em->getRepository(User::class);

        $lesson = $repoLesson->find($lessonId);
        $user = $repoUser->find($userId);

        $grade = new Grade();

        $form = $this->createForm(AddNewGradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grade = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $grade->setLesson($lesson);
            $grade->setPupil($user);
            $em->persist($grade);
            $em->flush();

            return $this->redirectToRoute('lesson_inf', ['id' => $lessonId]);
        }

        return $this->render('UserViews/FormView.html.twig', ['form' => $form->createView()]);
    }
}
