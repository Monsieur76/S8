<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     *  * @Assert\Length(
     *     min=3,
     *     max=255,
     *      minMessage="Le champ titre doit au moin {{limit}} caractères de long",
     *     maxMessage="Le champ titre ne peut pas contenir plus de {{limit}} caractères")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     * @Assert\NotBlank(message="Vous devez saisir un autheur.")
     *  * @Assert\Length(
     *     min=3,
     *     max=255,
     *      minMessage="Le champ autheur doit au moin {{limit}} caractères de long",
     *     maxMessage="Le champ autheur ne peut pas contenir plus de {{limit}} caractères")
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     *  * @Assert\Length(
     *     min=3,
     *     max=255,
     *      minMessage="Le champ contenue doit au moin {{limit}} caractères de long",
     *     maxMessage="Le champ contenue ne peut pas contenir plus de {{limit}} caractères")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDone;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="task")
     * @ORM\OrderBy({"order" = "DESC", "id" = "DESC"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $users;

    public function __construct()
    {
        $this->createdAt = new \Datetime();
        $this->isDone = false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function isDone()
    {
        return $this->isDone;
    }

    public function toggle($flag)
    {
        $this->isDone = $flag;
    }
    public function getUser(): ?User
    {
        return $this->users;
    }

    public function setUser(?User $users): self
    {
        $this->users = $users;

        return $this;
    }
    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }
}
