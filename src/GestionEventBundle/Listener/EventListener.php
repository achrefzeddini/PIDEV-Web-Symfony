<?php


namespace GestionEventBundle\Listener;



use AncaRebeca\FullCalendarBundle\Model\Event;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Security;
use GestionEventBundle\Entity\Reservation;

class EventListener
{
    /**
     * @var EntityManager
     */
    private $em;
    private $container;
    public function __construct(EntityManagerInterface $em,\Psr\Container\ContainerInterface $container,Security $security)
    {
        $this->em = $em;
        $this->container = $container;
        $this->security=$security;
    }

    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(\AncaRebeca\FullCalendarBundle\Event\CalendarEvent $calendarEvent)
    {




            $plannings = $this->em->getRepository(Reservation::class)->findBy(['iduser'=>$this->container->get('security.token_storage')->getToken()->getUser()]);

            foreach ($plannings as $p) {
                $date = \DateTime::createFromFormat('d/m/Y', $p->getDatereservation()->format('d/m/Y'));
                $date->setTime($p->getIdevent()->getHdebut(),0);
                $e =  new Event("Titre : " . $p->getIdevent()->getTitre() , $date);
                $datef = \DateTime::createFromFormat('d/m/Y', $p->getDatereservation()->format('d/m/Y'));
                $datef->setTime($p->getIdevent()->getHfin(),0);
                $e->setEndDate($datef);
                $e->isAllDay(false);

                $calendarEvent->addEvent($e);
            }



    }
}