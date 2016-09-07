<?php
    class Tamagotchi
    {
        private $name;
        private $food;
        private $attention;
        private $rest;

        function __construct($name)
        {
            $this->name = $name;
            $this->food = 20;
            $this->attention = 20;
            $this->rest = 20;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setFood($new_food)
        {
            $this->food = (int) $new_food;
        }

        function setAttention($new_attention)
        {
            $this->attention = (int) $new_attention;
        }

        function setRest($new_rest)
        {
            $this->rest = (int) $new_rest;
        }

        function getName()
        {
            return $this->name;
        }

        function getFood()
        {
            return $this->food;
        }

        function getAttention()
        {
            return $this->attention;
        }

        function getRest()
        {
            return $this->rest;
        }

        function save()
        {
            $_SESSION['Tamagotchi'] = $this;
        }

        function clickFeed()
        {
            return $this->food += 10;
        }

        function clickPlay()
        {
            return $this->attention += 10;
        }

        function clickSleep()
        {
            return $this->rest += 10;
        }

        function clickTime()
        {
            $this->food -= 5;
            $this->attention -= 5;
            $this->rest -= 5;

            return $this;
        }

        function checkDeath()
        {
            if ($this->food <= 0 || $this->attention <= 0 || $this->rest <= 0)
            {
                return true;
            } else {
                return false;
            }
        }

        static function getObject()
        {
            return $_SESSION['Tamagotchi'];
        }
    }
?>
