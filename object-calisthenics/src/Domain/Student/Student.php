<?php

namespace Alura\Calisthenics\Domain\Student;

use Alura\Calisthenics\Domain\Video\Video;
use Alura\Calisthenics\Domain\Email\Email;
use DateTimeInterface;
use Ds\Map;

class Student
{
    private Email $email;
    private DateTimeInterface $bd;
    private WatchedVideos $watchedVideos;
    private string $fName;
    private string $lName;
    public string $street;
    public string $number;
    public string $province;
    public string $city;
    public string $state;
    public string $country;

    public function __construct(Email $email, DateTimeInterface $bd, string $fName, string $lName, string $street, string $number, string $province, string $city, string $state, string $country)
    {
        $this->watchedVideos = new WatchedVideos();
        $this->email = $email;
        $this->bd = $bd;
        $this->fName = $fName;
        $this->lName = $lName;
        $this->street = $street;
        $this->number = $number;
        $this->province = $province;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
    }

    public function getFullName(): string
    {
        return "{$this->fName} {$this->lName}";
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBd(): DateTimeInterface
    {
        return $this->bd;
    }

    public function watch(Video $video, DateTimeInterface $date)
    {
        $this->watchedVideos->put($video, $date);
    }

    public function hasAccess(): bool
    {
        if ($this->watchedVideos->count() === 0) {
            return true;
        }

        $firstDate = $this->watchedVideos->dayOfFirstVideo();
        $today = new \DateTimeImmutable();

        return $firstDate->diff($today)->days < 90;
    }

    public function age(): int
    {
        $today = new \DateTimeImmutable();

        $dateInterval = $this->bd->diff($today);

        return $dateInterval->y;
    }
}
