<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateToDoTables extends Migration
{
    public function up()
    {
        // Create ToDo table
        $this->db->query('CREATE TABLE ToDo (
            ToDoID INT(11) NOT NULL AUTO_INCREMENT,
            Bezeichnung NVARCHAR(255),
            Beschreibung NVARCHAR(255),
            Datum DATETIME,
            Status INT(11),
            PRIMARY KEY (ToDoID)
        )');

        // Create Kategorie table
        $this->db->query('CREATE TABLE Kategorie (
            KategorieID INT(11) NOT NULL AUTO_INCREMENT,
            Bezeichnung NVARCHAR(255),
            PRIMARY KEY (KategorieID)
        )');

        // Create KategorieConn table
        $this->db->query('CREATE TABLE KategorieConn (
            ID INT(11) NOT NULL AUTO_INCREMENT,
            ToDoID INT(11),
            KategorieID INT(11),
            PRIMARY KEY (ID),
            FOREIGN KEY (ToDoID) REFERENCES ToDo(ToDoID),
            FOREIGN KEY (KategorieID) REFERENCES Kategorie(KategorieID)
        )');

        // Create Log table
        $this->db->query('CREATE TABLE Log (
            Datum DATETIME,
            KeyID INT(11),
            Aktion INT(11),
            Tabelle INT(11),
            DataJSON_Old NVARCHAR(255),
            DataJSON_New NVARCHAR(255)
        )');
    }

    public function down()
    {
        // Drop tables in reverse order to maintain foreign key constraints
        $this->db->query('DROP TABLE IF EXISTS KategorieConn');
        $this->db->query('DROP TABLE IF EXISTS Kategorie');
        $this->db->query('DROP TABLE IF EXISTS ToDo');
    }
}
