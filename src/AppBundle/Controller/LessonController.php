<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classes;
use AppBundle\Entity\Lesson;
use AppBundle\Form\AddLessonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        return $this->render(':LessonsViews:newLessonForm.html.twig', ['form' => $form->createView()]);
    }



}
