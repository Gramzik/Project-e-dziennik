<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * Grade
 *
 * @ORM\Table(name="grade")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GradesRepository")
 */
class Grade
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="grade", type="smallint")
     */
    private $grade;

    /**
     * @var Lesson
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lesson", inversedBy="grade")
     * @ORM\JoinColumn(name="lesson_id", referencedColumnName="id")
     */
    private $lesson;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="grade")
     * @ORM\JoinColumn(name="pupil_id", referencedColumnName="id")
     */
    private $pupil;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param mixed $grade
     */
    public function setGrade($grade): void
    {
        $this->grade = $grade;
    }

    /**
     * Set lesson
     *
     * @param \AppBundle\Entity\Lesson $lesson
     *
     * @return Grade
     */
    public function setLesson(\AppBundle\Entity\Lesson $lesson = null)
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * Get lesson
     *
     * @return \AppBundle\Entity\Lesson
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * Set pupil
     *
     * @param \AppBundle\Entity\User $pupil
     *
     * @return Grade
     */
    public function setPupil(\AppBundle\Entity\User $pupil = null)
    {
        $this->pupil = $pupil;

        return $this;
    }

    /**
     * Get pupil
     *
     * @return \AppBundle\Entity\User
     */
    public function getPupil()
    {
        return $this->pupil;
    }
}
