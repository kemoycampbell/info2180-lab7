<?php

//remember code reuse principle
function error()
{
    print "Content-Type:text/html\n";
    print "\n";
    print "<p>No query provided</p>";
    exit;
}

if(!isset($_GET['country']) && !isset($_GET['all']))
{
    error();
}

//if we get here we know the $_GET are set. Always convert inputs to htmlentities
$country = htmlentities(trim($_GET['country']));
$all = htmlentities(trim($_GET['all']));

if(empty($country) && empty($all))
{
    error();
}


//this approach ensure that all can only be true... if you were to check ===false, it is easy to get around
//by supplying anything other than false.
if(empty($country) && $all!=='true')
{
    error();
}

//only establish database connection once
$host = getenv('IP');
$username = getenv('C9_USER');
$password = '';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

//if all is enable to true, we dont need to search the "country" as well since it will already be included
if($all==='true')
{
    //always wrap your quries in a try and catch. Queries can failed due to many factors. For example,
    //what if the table 'countries' doesn't exist in your database?
    try
    {
        $stmt = $conn->query("SELECT * FROM countries");

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<ul class="mdl-list">';
        foreach ($results as $row) {
            echo '<li class="mdl-list__item"><span class="mdl-list__item-primary-content"><img src="gif/' . strtolower($row["code"]) . '.gif" style="padding: 10px;">'
                . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</span></li><hr>';
        }
        echo '</ul>';

        exit();
    }

        //a rule of thumb, never echo your exception, safely log it somewhere so you can investigate it later.
    catch(Exception $e)
    {
        //if you decided to go with log, research logoverflow vulnerability
        //your action goes here.
    }
}

//anything else we will just search by country...we have take care of our requirements 
//above so we dont have anything to worry about.
else
{
    //always use prepare statement when processing a user's input, never directly query the input in your sql query
    //statement.

    //$stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%';"); //this is what you had

    //same as above, always wrap in try and catch.
    try
    {
        $stmt = $conn->prepare("SELECT * from countries WHERE name LIKE CONCAT('%', :country, '%')");
        $stmt->bindParam(':country',$country,PDO::PARAM_STR);
        $stmt->execute();

        //did we find match?
        if($stmt->rowCount() > 0)
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo '<ul class="mdl-list">';
            foreach ($results as $row) {
                echo '<li class="mdl-list__item"><span class="mdl-list__item-primary-content"><img src="gif/' . strtolower($row["code"]) . '.gif" style="padding: 10px;">'
                    . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</span></li><hr>';
            }
            echo '</ul>';

            exit();
        }

        //no match
        else
        {
            echo '<ul class="mdl-list">';
            echo "We were not able to find any match for $country";
            echo '</ul>';

            exit();
        }
    }

    catch(Exception $e)
    {
        //your action goes here
    }

}

?>
