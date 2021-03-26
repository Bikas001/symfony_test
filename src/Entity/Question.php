<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="question")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="question")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text")
     */
    private $askquestion;

    /**
     * @ORM\OneToMany(targetEntity=Reply::class, mappedBy="question", orphanRemoval=true)
     */
    private $reply;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="question", orphanRemoval=true)
     */
    private $likes;

    public function __construct()
    {
        $this->reply = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAskquestion(): ?string
    {
        return $this->askquestion;
    }

    public function setAskquestion(string $askquestion): self
    {
        $this->askquestion = $askquestion;

        return $this;
    }

    /**
     * @return Collection|Reply[]
     */
    public function getReply(): Collection
    {
        return $this->reply;
    }

    public function addReply(Reply $reply): self
    {
        if (!$this->reply->contains($reply)) {
            $this->reply[] = $reply;
            $reply->setQuestion($this);
        }

        return $this;
    }

    public function removeReply(Reply $reply): self
    {
        if ($this->reply->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getQuestion() === $this) {
                $reply->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setQuestion($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getQuestion() === $this) {
                $like->setQuestion(null);
            }
        }

        return $this;
    }




}
