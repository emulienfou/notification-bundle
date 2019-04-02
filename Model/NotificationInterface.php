<?php

namespace Mgilet\NotificationBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface NotificationInterface
 *
 * @package Mgilet\NotificationBundle\Model
 */
interface NotificationInterface
{

    /**
     * @return int Notification Id
     */
    public function getId();

    /**
     * @return \DateTime
     */
    public function getDate();

    /**
     * @param \DateTime $date
     *
     * @return NotificationInterface
     */
    public function setDate($date);

    /**
     * @return string Notification subject
     */
    public function getSubject();

    /**
     * @param string $subject Notification subject
     *
     * @return NotificationInterface
     */
    public function setSubject($subject);

    /**
     * @return string Notification message
     */
    public function getMessage();

    /**
     * @param string $message Notification message
     *
     * @return NotificationInterface
     */
    public function setMessage($message);

    /**
     * @return string Link to redirect the user
     */
    public function getLink();

    /**
     * @param string $link Link to redirect the user
     *
     * @return NotificationInterface
     */
    public function setLink($link);

    /**
     * @return ArrayCollection|NotifiableNotification[]
     */
    public function getNotifiableNotifications();

    /**
     * @param NotifiableNotificationInterface $notifiableNotification
     *
     * @return NotificationInterface
     */
    public function addNotifiableNotification(NotifiableNotificationInterface $notifiableNotification);

    /**
     * @param NotifiableNotificationInterface $notifiableNotification
     *
     * @return NotificationInterface
     */
    public function removeNotifiableNotification(NotifiableNotificationInterface $notifiableNotification);
}