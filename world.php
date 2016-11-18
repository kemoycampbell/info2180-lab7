<?php

$host = getenv('IP');
$username = getenv('C9_USER');
$password = '';
$dbname = 'world';

$country_set = isset($_GET["country"]);
$all_set = isset($_GET["all"]);

if ($country_set && $all_set) {
    $country = $_GET["country"];
    $all = $_GET["all"];
    
    if (empty($country) && empty($all)) {
        print "Content-Type:text/html\n";
        print "\n";
        print "<p>No query provided</p>";
        
        exit();
    }
    
    if (empty($country) && $all == "false") {
        print "Content-Type:text/html\n";
        print "\n";
        print "<p>Invalid query</p>";
        
        exit();
    }
    
    if ($all == "true") {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
        $stmt = $conn->query("SELECT * FROM countries;");
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<ul>';
        foreach ($results as $row) {
            echo '<li>' . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</li>';
        }
        echo '</ul>';
        
        exit();
    }
    
    if (!empty($country)) {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
        $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%';");
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<ul>';
        foreach ($results as $row) {
            echo '<li>' . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</li>';
        }
        echo '</ul>';
        
        exit();
    }
}

if ($country_set && !$all_set) {
    $country = $_GET["country"];
    
    if (empty("country")) {
        print "Content-Type:text/html\n";
        print "\n";
        print "<p>No query provided</p>";
        
        exit();   
    }
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%';");
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<ul>';
    foreach ($results as $row) {
        echo '<li>' . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</li>';
    }
    echo '</ul>';
    
    exit();
}

if ($all_set && !$country_set) {
    $all = $_GET["all"];
    
    if (empty("all") || $all == "false") {
        print "Content-Type:text/html\n";
        print "\n";
        print "<p>No query provided</p>";
        
        exit();   
    }
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    $stmt = $conn->query("SELECT * FROM countries;");
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<ul>';
    foreach ($results as $row) {
        echo '<li>' . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</li>';
    }
    echo '</ul>';
    
    exit();
}

if (!$country_set && !$all_set) {
    print "Content-Type:text/html\n";
    print "\n";
    print "<p>No query provided</p>";
    
    exit();
}
