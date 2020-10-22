<?php


namespace MeetingBundle\Listener;

use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use MeetingBundle\Entity\CalendarEvent as MyCustomEvent;
use MeetingBundle\Entity\CalendarEvent;

class LoadDataListener
{
    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDate();
        $endDate = $calendarEvent->getEndDate();


        //You may want do a custom query to populate the events

        $calendarEvent->addEvent(new MyCustomEvent('Event Title 1', new \DateTime()));
        $calendarEvent->addEvent(new MyCustomEvent('Event Title 2', new \DateTime()));

        $calendarEvent->setAllDay(true);
    }

}