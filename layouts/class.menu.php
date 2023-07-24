<?php

require_once('../layouts/dbconexion_pdo.php');

class menu
{
	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
	}

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function getMenuPpal()
    {
        try {

            $stmt = $this->conn->prepare("SELECT * FROM menu WHERE status='1' AND menu_orden > 1 ORDER BY menu_orden ASC");
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            return $stat;
        }
    }

    public function getSubMenu($id)
    {

        try {
            $stmt = $this->conn->prepare("SELECT * FROM menu_sub WHERE status='1' AND id_menu = :id ORDER BY sub_menu_orden ASC");
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            return $stat;
        }
    }

    public function getSubMenuLevel2($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM menu_sub_level_2 WHERE status='1' AND id_sub_menu = :id ORDER BY sub_menu_orden ASC");
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            return $stat;
        }
    }

    public function getSubMenuLevel3($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM menu_sub_level_3 WHERE status='1' AND id_sub_menu = :id ORDER BY sub_menu_orden ASC");
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            return $stat;
        }
    }


}
