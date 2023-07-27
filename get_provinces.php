<?php
require_once './conndb.php';

header('Content-Type: application/json');

class ProvincesHandler
{
    private $dbconn;

    public function __construct()
    {
        $db = new Database();
        $this->dbconn = $db->dbconn;
    }

    public function handleRequest($request)
    {
        if (isset($request['type']) && isset($request['id'])) {
            $provincetype = $request['type'];
            $provincevalue = $request['id'];

            if ($provincetype == 'AM') {
                return $this->handleAmphures($provincevalue);
            } elseif ($provincetype == 'TA') {
                return $this->handleTambons($provincevalue);
            } elseif ($provincetype == 'ZC') {
                return $this->handleZip($provincevalue);
            } elseif ($provincetype == 'PR') {
                return $this->handleProvinces();
            }
        }
    }

    private function handleAmphures($provinceId)
    {
        $sql = "SELECT * FROM th_amphures WHERE province_id = :province_id ORDER by CONVERT( name_th USING tis620 ) ASC";
        $query = $this->dbconn->prepare($sql);
        $query->bindParam(':province_id', $provinceId, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        $json = array();
        array_push($json, "<option value=''>--- เลือกอำเภอ ---</option>");

        if ($query->rowCount() > 0) {
            foreach ($result as $res) {
                array_push($json, "<option value='$res->id'>" . $res->name_th . "</option>");
            }
        }

        return json_encode($json);
    }

    private function handleTambons($amphureId)
    {
        $sql = "SELECT * FROM th_tambons WHERE amphure_id = :amphure_id ORDER by CONVERT( name_th USING tis620 ) ASC";
        $query = $this->dbconn->prepare($sql);
        $query->bindParam(':amphure_id', $amphureId, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        $json = array();
        array_push($json, "<option value=''>--- เลือกตำบล ---</option>");

        if ($query->rowCount() > 0) {
            foreach ($result as $res) {
                array_push($json, "<option value='$res->id'>" . $res->name_th . "</option>");
            }
        }

        return json_encode($json);
    }

    private function handleZip($tambonId)
    {
        $sql = "SELECT * FROM th_tambons WHERE id = :tambon_id ORDER by CONVERT( name_th USING tis620 ) ASC";
        $query = $this->dbconn->prepare($sql);
        $query->bindParam(':tambon_id', $tambonId, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        $json = array();
        // array_push($json, "<option value=''>--- เลือกรหัสไปรษณีย์ ---</option>");

        if ($query->rowCount() > 0) {
            foreach ($result as $res) {
                array_push($json, "<option value='$res->id'>" . $res->zip_code . "</option>");
            }
        }

        return json_encode($json);
    }


    private function handleProvinces()
    {
        $sql = "SELECT * FROM th_provinces ORDER by CONVERT( name_th USING tis620 ) ASC";
        $query = $this->dbconn->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        $json = array();
        array_push($json, "<option value=''>--- เลือกจังหวัด ---</option>");

        foreach ($result as $res) {
            array_push($json, "<option value='$res->id'>" . $res->name_th . "</option>");
        }

        return json_encode($json);
    }
}

$handler = new ProvincesHandler();
$response = $handler->handleRequest($_REQUEST);
echo $response;
