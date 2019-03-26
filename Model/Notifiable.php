<?php

namespace Mgilet\NotificationBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class NotifiableEntity
 * @package Mgilet\NotificationBundle\Model
 *
 * @ORM\MappedSuperclass(repositoryClass="Mgilet\NotificationBundle\Repository\NotifiableRepository")
 * @UniqueEntity(fields={"identifier", "class"})
 */
abstract class Notifiable implements NotifiableInterface, \JsonSerializable
{

    /**
     * @var string $identifier
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $identifier;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $class;

    /**
     * @var NotifiableNotification[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Mgilet\NotificationBundle\Model\NotifiableNotificationInterface", mappedBy="notifiableEntity", cascade={"persist"})
     */
    protected $notifiableNotifications;

    /**
     * AbstractNotifiableEntity constructor.
     *
     * @param $identifier
     * @param $class
     */
    public function __construct($identifier, $class)
    {
        $this->identifier = $identifier;
        $this->class = $class;
        $this->notifiableNotifications = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     *
     * @return Notifiable
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return Notifiable
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return ArrayCollection|NotifiableNotification[]
     */
    public function getNotifiableNotifications()
    {
        return $this->notifiableNotifications;
    }

    /**
     * @param NotifiableNotification $notifiableNotification
     *
     * @return $this
     */
    public function addNotifiableNotification(NotifiableNotification $notifiableNotification)
    {
        if (!$this->notifiableNotifications->contains($notifiableNotification)) {
            $this->notifiableNotifications[] = $notifiableNotification;
            $notifiableNotification->setNotifiableEntity($this);
        }

        return $this;
    }

    /**
     * @param NotifiableNotification $notifiableNotification
     *
     * @return $this
     */
    public function removeNotifiableNotification(NotifiableNotification $notifiableNotification)
    {
        if ($this->notifiableNotifications->contains($notifiableNotification)) {
            $this->notifiableNotifications->removeElement($notifiableNotification);
            $notifiableNotification->setNotifiableEntity(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id'         => $this->getId(),
            'identifier' => $this->getIdentifier(),
            'class'      => $this->getClass()
        ];
    }
}
