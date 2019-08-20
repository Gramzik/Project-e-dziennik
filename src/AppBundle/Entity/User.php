<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string")
     */
    protected $last_name;

    /**
     * @var Classes
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Classes", mappedBy="educator")
     */
    private $educatorClass;

    /**
     * @var Lesson
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Lesson", mappedBy="teacher")
     */
    private $lesson;

    /**
     * @var Classes
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Classes", inversedBy="pupil")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id")
     */
    private $class;

    public function __construct()
    {
        parent::__construct();
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set class
     *
     * @param \AppBundle\Entity\Classes $class
     *
     * @return User
     */
    public function setClass(\AppBundle\Entity\Classes $class = null)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return \AppBundle\Entity\Classes
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set educatorClass
     *
     * @param \AppBundle\Entity\Classes $educatorClass
     *
     * @return User
     */
    public function setEducatorClass(\AppBundle\Entity\Classes $educatorClass = null)
    {
        $this->educatorClass = $educatorClass;

        return $this;
    }

    /**
     * Get educatorClass
     *
     * @return \AppBundle\Entity\Classes
     */
    public function getEducatorClass()
    {
        return $this->educatorClass;
    }

    /**
     * Set lesson
     *
     * @param \AppBundle\Entity\Lesson $lesson
     *
     * @return User
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
