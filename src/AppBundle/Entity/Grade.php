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
    private const ONE = 1;
    private const TWO = 2;
    private const THREE = 3;
    private const FOUR = 4;
    private const FIVE = 5;
    private const SIX = 6;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="grade", type="smallint", columnDefinition="enum(1,2,3,4,5,6)")
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
        if (!in_array($grade, [self::ONE, self::TWO, self::THREE, self::FOUR, self::FIVE, self::SIX])) {
            throw new InvalidArgumentException("Nieprawidłowa ocena.");
        }
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
}
