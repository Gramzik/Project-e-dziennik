<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classes
 *
 * @ORM\Table(name="classes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClassesRepository")
 */
class Classes
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="educatorClass")
     * @ORM\JoinColumn(name="educator_id", referencedColumnName="id")
     */
    private $educator;

    /**
     * @var User
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="class")
     */
    private $pupil;

    /**
     * @var Lesson
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Lesson", mappedBy="class")
     */
    private $lesson;

    public function __construct()
    {
        $this->pupil = new ArrayCollection();
        $this->lesson = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Classes
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set educator
     *
     * @param \AppBundle\Entity\User $educator
     *
     * @return Classes
     */
    public function setEducator(\AppBundle\Entity\User $educator = null)
    {
        $this->educator = $educator;

        return $this;
    }

    /**
     * Get educator
     *
     * @return \AppBundle\Entity\User
     */
    public function getEducator()
    {
        return $this->educator;
    }

    /**
     * Add pupil
     *
     * @param \AppBundle\Entity\User $pupil
     *
     * @return Classes
     */
    public function addPupil(\AppBundle\Entity\User $pupil)
    {
        $this->pupil[] = $pupil;

        return $this;
    }

    /**
     * Remove pupil
     *
     * @param \AppBundle\Entity\User $pupil
     */
    public function removePupil(\AppBundle\Entity\User $pupil)
    {
        $this->pupil->removeElement($pupil);
    }

    /**
     * Get pupil
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPupil()
    {
        return $this->pupil;
    }

    /**
     * Add lesson
     *
     * @param \AppBundle\Entity\Lesson $lesson
     *
     * @return Classes
     */
    public function addLesson(\AppBundle\Entity\Lesson $lesson)
    {
        $this->lesson[] = $lesson;

        return $this;
    }

    /**
     * Remove lesson
     *
     * @param \AppBundle\Entity\Lesson $lesson
     */
    public function removeLesson(\AppBundle\Entity\Lesson $lesson)
    {
        $this->lesson->removeElement($lesson);
    }

    /**
     * Get lesson
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLesson()
    {
        return $this->lesson;
    }
}
