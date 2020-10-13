<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=50)
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=65535)
     */
    private $body;

    /**
     * @ORM\Column(type="text", length=65535)
     */
    private $cast;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cert;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $class;

    /**
     * @ORM\Column(type="text", length=65535)
     */
    private $directors;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headline;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastUpdated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quote;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reviewAuthor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $skyGoId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $skyGoUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sum;

    /**
     * @ORM\Column(type="text", length=65535)
     */
    private $synopsis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="text", length=65535, nullable=true)
     */
    private $videos;

    /**
     * @ORM\Column(type="text", length=65535, nullable=true)
     */
    private $viewingWindow;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="movie")
     */
    private $image;

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getCast()
    {
        return $this->cast;
    }

    /**
     * @param mixed $cast
     */
    public function setCast($cast)
    {
        $this->cast = $cast;
    }

    /**
     * @return mixed
     */
    public function getCert()
    {
        return $this->cert;
    }

    /**
     * @param mixed $cert
     */
    public function setCert($cert)
    {
        $this->cert = $cert;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getDirectors()
    {
        return $this->directors;
    }

    /**
     * @param mixed $directors
     */
    public function setDirectors($directors)
    {
        $this->directors = $directors;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @param mixed $genres
     */
    public function setGenres($genres)
    {
        $this->genres = $genres;
    }

    /**
     * @return mixed
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @param mixed $headline
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    }

    /**
     * @return mixed
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @param mixed $lastUpdated
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;
    }

    /**
     * @return mixed
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param mixed $quote
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getReviewAuthor()
    {
        return $this->reviewAuthor;
    }

    /**
     * @param mixed $reviewAuthor
     */
    public function setReviewAuthor($reviewAuthor)
    {
        $this->reviewAuthor = $reviewAuthor;
    }

    /**
     * @return mixed
     */
    public function getSkyGoId()
    {
        return $this->skyGoId;
    }

    /**
     * @param mixed $skyGoId
     */
    public function setSkyGoId($skyGoId)
    {
        $this->skyGoId = $skyGoId;
    }

    /**
     * @return mixed
     */
    public function getSkyGoUrl()
    {
        return $this->skyGoUrl;
    }

    /**
     * @param mixed $skyGoUrl
     */
    public function setSkyGoUrl($skyGoUrl)
    {
        $this->skyGoUrl = $skyGoUrl;
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param mixed $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * @return mixed
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * @param mixed $synopsis
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param mixed $videos
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
    }

    /**
     * @return mixed
     */
    public function getViewingWindow()
    {
        return $this->viewingWindow;
    }

    /**
     * @param mixed $viewingWindow
     */
    public function setViewingWindow($viewingWindow)
    {
        $this->viewingWindow = $viewingWindow;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setMovie($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->contains($image)) {
            $this->image->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getMovie() === $this) {
                $image->setMovie(null);
            }
        }

        return $this;
    }
}
