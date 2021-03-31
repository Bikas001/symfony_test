<?php

namespace App\Entity;

use App\Repository\ReplyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReplyRepository::class)
 */
class Reply
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="reply")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;



    /**
     * @ORM\Column(type="text")
     */
    private $replytext;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getReplytext(): ?string
    {
        return $this->replytext;
    }

    public function setReplytext(string $replytext): self
    {
        $this->replytext = $replytext;

        return $this;
    }

    public function __toString(){
        return $this->replytext;
    }
}
