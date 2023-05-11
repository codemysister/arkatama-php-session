<?php

function getUserDetail($id){
    global $conn;
    $query = "SELECT  s.name, r.name as role, s.email, s.address, s.phone, s.avatar, s.password, r.id as role_id FROM users AS s
    JOIN roles AS r ON s.role_id = r.id WHERE s.id = '$id'";
    $result = mysqli_query($conn, $query);
    return $result;
}

function getRoles()
{
    global $conn;
    $query = "SELECT *
    FROM roles";

    $result = mysqli_query($conn, $query);

    return $result;
}