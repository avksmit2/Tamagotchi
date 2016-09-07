<?php
date_default_timezone_set('America/Los_Angeles');

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Tamagotchi.php";

    $app = new Silex\Application();

    session_start();
    if(empty($_SESSION['Tamagotchi'])) {
        $_SESSION['Tamagotchi'] = "";
    }

    $app->get("/", function() {

        $output = "";

        $output .= "
            <form id='name-form' action='/newStats' method='post'>
                <label for='name'>Name your Tamagotchi: </label>
                <input id='name' name='name' type='text'>

                <button type='submit'>Ok!</button>
            </form>
        ";

        return $output;
    });

    $app->post('/newStats', function() {
        $tamagotchi = new Tamagotchi($_POST['name']);
        $tamagotchi->save();
        return "
            <form id='stats' action='/interact' method='post'>
                <h1>Here are the details of your Tamagotchi!</h1>
                <p>" . $tamagotchi->getName() . ": Food - " . $tamagotchi->getFood() . ", Attention - " . $tamagotchi->getAttention() . ", Rest - " . $tamagotchi->getRest() . "</p>
                <button type='submit'>Time Passes</button>
            </form>
        ";
    });

    $app->post('/stats', function() {
        $tamagotchi = Tamagotchi::getObject();
        $tamagotchi->save();

        $output = "";

        $output .= "
            <form id='stats' action='/interact' method='post'>
                <h1>Here are the details of your Tamagotchi!</h1>
                <p>" . $tamagotchi->getName() . ": Food - " . $tamagotchi->getFood() . ", Attention - " . $tamagotchi->getAttention() . ", Rest - " . $tamagotchi->getRest() . "</p>
                <button type='submit'>Time Passes</button>
            </form>
        ";

        return $output;
    });

    $app->post('/interact', function() {
        $tamagotchi = Tamagotchi::getObject();
        $tamagotchi->clickTime();
        $tamagotchi->save();

        $output = "";

        if ($tamagotchi->checkDeath()) {
            $output .= "
                <h1>You killed " . $tamagotchi->getName() . "!</h1>
            ";
        } else {
            $output .= "
                <form id='feed' action='/feed' method='post'>
                    <button type='submit'>Feed Tamagotchi</button>
                </form>
                <form id='play' action='/play' method='post'>
                    <button type='submit'>Play with Tamagotchi</button>
                </form>
                <form id='sleep' action='/sleep' method='post'>
                    <button type='submit'>Put Tamagotchi to sleep</button>
                </form>
            ";
        }
        return $output;
    });

    $app->post('/feed', function() {
        $Tamagotchi = Tamagotchi::getObject();
        $Tamagotchi->clickFeed();
        $Tamagotchi->save();

        $output = "";

        $output .= "
            <form action='/stats' method='post'>
                <h1>You fed " . $Tamagotchi->getName() . "!</h1>
                <button type='submit'>Ok!</button>
            </form>
        ";
        return $output;
    });
    $app->post('/play', function() {
        $Tamagotchi = Tamagotchi::getObject();
        $Tamagotchi->clickPlay();
        $Tamagotchi->save();

        $output = "";

        $output .= "
            <form action='/stats' method='post'>
                <h1>You played with " . $Tamagotchi->getName() . "!</h1>
                <button type='submit'>Ok!</button>
            </form>
        ";
        return $output;
    });
    $app->post('/sleep', function() {
        $Tamagotchi = Tamagotchi::getObject();
        $Tamagotchi->clickSleep();
        $Tamagotchi->save();

        $output = "";

        $output .= "
            <form action='/stats' method='post'>
                <h1>You gave " . $Tamagotchi->getName() . " a nap!</h1>
                <button type='submit'>Ok!</button>
            </form>
        ";
        return $output;
    });
    return $app;

 ?>
