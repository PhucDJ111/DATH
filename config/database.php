<?php

$host = 'localhost';
$dbname = 'todo_app';
$username = 'root';
$password = '';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4"; //cau hinh chuoi ket noi

$pdo = new PDO($dsn, $username, $password); //cau hinh ket noi database

$pdo->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
); //cau hinh bao loi