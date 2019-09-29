<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classes;
use AppBundle\Entity\User;
use AppBundle\Form\AddClassType;
use AppBundle\Form\AddUserToClassType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ClassController extends Controller
{

    /**
     * @Route("/admin/newClass", name="new_class")
     */
    public function newClassAction(Request $request)
    {
        $class = new Classes();

        $form = $this->createForm(AddClassType::class, $class);
        $form->handleRequest($request);

        //check if form was submitted
        if ($form->isSubmitted() && $form->isValid()) {
            $class = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($class);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        //if not show form with twig
        return $this->render(':ClassViews:newClassForm.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/showClasses", name="show_classes")
     */
    public function showAllClassesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Classes::class);

        $classes = $repo->findAll();

        return $this->render(':ClassViews:showAllClasses.html.twig', ['classes' => $classes]);
    }

    /**
     * @Route("/classInfo/{id}", name="class_info")
     */
    public function showClassInfoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Classes::class);

        $class = $repo->find($id);
        $pupils = $class->getPupil();
        $lessons = $class->getLesson();

        return $this->render(':ClassViews:showClass.html.twig', ['class' => $class, 'pupils' => $pupils, 'lessons' => $lessons]);
    }

    /**
     * @Route("/educator/addUserToClass/{classId}", name="add_user_to_class")
     */
    public function addUserToClassAction(Request $request, $classId)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $userId = $user->getId();
        $userRole = $user->getRoles();
        $role = 'ROLE_SUPER_ADMIN';

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Classes::class);

        $class = $repo->find($classId);
        $educatorId = $class->getEducator()->getId();

        if ($educatorId == $userId or isset($role,$userRole)) {

            $form = $this->createForm(AddUserToClassType::class, $class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $class = $form->getData();
                foreach ($class->getPupil() as $pupil) {
                    $pupil->setClass($class);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($class);
                $em->flush();
                return $this->redirectToRoute('class_info', ['id' => $classId]);
            }

            return $this->render(':ClassViews:addPupilToClass.html.twig', ['form' => $form->createView()]);
        } else {
            $this->addFlash('notice','Nie jesteś wychowawcą tej klasy.');
            return $this->redirectToRoute('class_info', ['id' => $classId]);
        }
    }

    /**
     * @Route("/showUserClass/{id}", name="show_user_class")
     */
    public function showUserClassAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $user = $repo->find($id);
        $class = $user->getClass();
        $classId = $class->getId();

        return $this->redirectToRoute('class_info', ['id' => $classId]);
    }
}
