<?php

namespace Mgilet\NotificationBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class NotifiableNotification
 * @package Mgilet\NotificationBundle\Model
 *
 * @ORM\MappedSuperclass(repositoryClass="Mgilet\NotificationBundle\Repository\NotifiableNotificationRepository")
 *
 */
abstract class NotifiableNotification implements NotifiableNotificationInterface, \JsonSerializable
{

    /**
     * @var boolean
     * @ORM\Column(name="seen", type="boolean")
     */
    protected $seen;

    /**
     * @var Notification
     * @ORM\ManyToOne(targetEntity="Mgilet\NotificationBundle\Model\NotificationInterface", inversedBy="notifiableNotifications", cascade={"persist"})
     */
    protected $notification;

    /**
     * @var Notifiable
     * @ORM\ManyToOne(targetEntity="Mgilet\NotificationBundle\Model\NotifiableInterface", inversedBy="notifiableNotifications", cascade={"persist"})
     */
    protected $notifiableEntity;

    /**
     * AbstractNotification constructor.
     */
    public function __construct()
    {
        $this->seen = false;
    }

    /**
     * @return boolean Seen status of the notification
     */
    public function isSeen()
    {
        return $this->seen;
    }

    /**
     * @param boolean $isSeen Seen status of the notification
     * @return $this
     */
    public function setSeen($isSeen)
    {
        $this->seen = $isSeen;

        return $this;
    }

    /**
     * @return Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param Notification $notification
     *
     * @return NotifiableNotification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return Notifiable
     */
    public function getNotifiableEntity()
    {
        return $this->notifiableEntity;
    }

    /**
     * @param Notifiable $notifiableEntity
     *
     * @return NotifiableNotification
     */
    public function setNotifiableEntity(Notifiable $notifiableEntity = null)
    {
        $this->notifiableEntity = $notifiableEntity;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id'           => $this->getId(),
            'seen'         => $this->isSeen(),
            'notification' => $this->getNotification(),
            // for the notifiable, we serialize only the id:
            // - we don't need not want the FQCN exposed
            // - most of the time we will have a proxy and don't want to trigger lazy loading
            'notifiable'   => [ 'id' => $this->getNotifiableEntity()->getId() ]
        ];
    }
}
