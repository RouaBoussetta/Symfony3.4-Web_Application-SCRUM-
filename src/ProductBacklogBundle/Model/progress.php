<?php


namespace ProductBacklogBundle\Model;


class progress
{


    private $totaldone;
    private $todo;

    /**
     * @return mixed
     */
    public function getTotaldone()
    {
        return $this->totaldone;
    }

    /**
     * @param mixed $totaldone
     */
    public function setTotaldone($totaldone)
    {
        $this->totaldone = $totaldone;
    }

    /**
     * @return mixed
     */
    public function getTodo()
    {
        return $this->todo;
    }

    /**
     * @param mixed $todo
     */
    public function setTodo($todo)
    {
        $this->todo = $todo;
    }



}