<?php

require("config.php");

function connect()
{
    try {
        //Instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME,
            DB_PASSWORD);
        //echo "Connected to database!!!";
        return $dbh;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return;
    }
}

function getStudents()
{
    global $dbh;

    //1. define the query
    $sql = "SELECT * FROM student ORDER BY last, first";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //3. bind parameters

    //4. execute the statement
    $statement->execute();

    //5. return the result
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    //print_r($result);
    return $result;
}

function addStudent($sid, $last, $first, $birthdate, $gpa, $advisor)
{
    global $dbh;

    //1. define the query
    $sql = "INSERT INTO student
            VALUES (:sid, :last, :first, :birthdate, :gpa, :advisor)";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //3. bind parameters
    $statement->bindParam(':sid', $sid, PDO::PARAM_STR);
    $statement->bindParam(':last', $last, PDO::PARAM_STR);
    $statement->bindParam(':first', $first, PDO::PARAM_STR);
    $statement->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
    $statement->bindParam(':gpa', $gpa, PDO::PARAM_STR);
    $statement->bindParam(':advisor', $advisor, PDO::PARAM_STR);

    //4. execute the statement
    $success = $statement->execute();

    //5. return the result
    return $success;
}

function getStudent($sid)
{
    global $dbh;

    //1. Define the query
    $sql = "SELECT * FROM student WHERE sid = :sid";

    //2. Prepare the statement
    $statement = $dbh->prepare($sql);

    //3. Bind parameters
    $statement->bindParam(':sid', $sid, PDO::PARAM_STR);


    //4. Execute the query
    $statement->execute();

    //5. Get the results
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}