<?php

/*
 * *************************************************************************************************************************
 * * CORAL Usage Statistics Reporting Module v. 1.0
 * *
 * * Copyright (c) 2010 University of Notre Dame
 * *
 * * This file is part of CORAL.
 * *
 * * CORAL is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * *
 * * CORAL is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * *
 * * You should have received a copy of the GNU General Public License along with CORAL. If not, see <http://www.gnu.org/licenses/>.
 * *
 * *************************************************************************************************************************
 */
class Parameter implements ParameterInterface {
    public static $display = '';
    public static $report = null;
    public static $ajax_parmValues = null;

    public $value = null;
    public $db;
    public $id;
    public $reportID;
    public $prompt;
    public $addWhereClause;
    public $typeCode;
    public $requiredInd;
    public $addWhereNum;
    public $sql;
    public $parentID;
    public $sqlRestriction;

    public function __construct($reportID, $db, $dbData, $value=null) {
        $this->db = $db;
        $this->reportID = $reportID;

        if ($dbData!==null) {
            $this->id = $dbData['reportParameterID'];
            $this->prompt = $dbData['parameterDisplayPrompt'];
            $this->addWhereClause = $dbData['parameterAddWhereClause'];
            $this->typeCode = $dbData['parameterTypeCode'];
            $this->requiredInd = $dbData['requiredInd']===1;
            $this->addWhereNum = $dbData['parameterAddWhereNumber'];
            $this->sql = $dbData['parameterSQLStatement'];
            $this->parentID = $dbData['parentReportParameterID'];
            $this->sqlRestriction = $dbData['parameterSQLRestriction'];
        }

        if ($value!==null) {
            $this->value = $value;
        } else {
            $this->value = $this->value();
        }
    }

    public function value() {
        if (isset($_REQUEST["prm_$this->id"])) {
            $val = trim($_REQUEST["prm_$this->id"]);
            if ($val !== '') {
                return $val;
            }
        }
        return null;
    }

    public function process() {
        if ($this->value !== null && trim("$this->value")!=='') {
            $this->value = strtoupper($this->value);
            Parameter::$report->addWhere[$this->addWhereNum] .= " AND " . preg_replace('/PARM/',$this->value,$this->addWhereClause);
            FormInputs::addVisible("prm_$this->id", $this->value);
            Parameter::$display .= $this->description();
        }
    }

    public function description() {
        return "<b>{$this->prompt}:</b> '$this->value'<br/>";
    }

    private function formCommon() {
        echo "<div id='div_parm_$this->id'>
        <br />
        <label for='prm_$this->id'>$this->prompt</label>
        <input type='text' name='prm_$this->id' class='opt' value=\"$this->value\"/>";
        echo "</div>";
    }

    public function form() {
        $this->formCommon();
    }

    public function ajaxGetChildUpdate() {
        $this->formCommon();
    }

    public function ajaxGetChildParameters() {
        foreach ( $this->getChildren() as $parm ) {
            echo $parm->id . "|";
        }
    }

    public static function setReport(Report $report) {
        Parameter::$report = $report;
    }

    // used only for allowing access to admin page
    public function getSelectValues($parentValue) {
        if (trim($this->sql)==='') {
            throw new RuntimeException("Parameter not fully initialized, missing sql, cannot query DB");
        }

        // get report info so we can determine which database to use
        $parmReport = ReportFactory::makeReport($this->reportID);
        Config::init();

        // if this is a restricted sql dependent on previous value
        if ($this->sqlRestriction != '') {
            if ($parentValue) {
                $parmSQL = str_replace(
                    "PARM", $parentValue,
                    str_replace("ADD_WHERE", $this->sqlRestriction, $this->sql)
                );
            } else {
                $parmSQL = str_replace("ADD_WHERE", "", $this->sql);
            }
        } else {
            $parmSQL = str_replace("ADD_WHERE", "", $this->sql);
        }

        $result = $this->db
            ->selectDB(Config::$database->{$parmReport->dbname})
            ->query($parmSQL)
            ->fetchRows();

        $num_rows = count($result);
        $valueArray = array();
        for ($i = 0; $i < $num_rows; ++$i) {
            $valueArray[] = array('cde' => $result[$i][0],'val' => $result[$i][1]);
        }
        return $valueArray;
    }

    // used only for allowing access to admin page
    public function isParent() {
        // set database to reporting database name
        Config::init();
        $row = $this->db
            ->selectDB(Config::$database->name)
            ->query("SELECT count(parentReportParameterID) parent_count
            FROM ReportParameterMap
            WHERE parentReportParameterID = '{$this->id}'")
            ->fetchRow(MYSQLI_ASSOC);
        return $row['parent_count'] > 0;
    }

    // removes associated parameters
    public function getChildren() {
        Config::init();
        $objects = array();
        foreach($this->db
            ->selectDB(Config::$database->name)
            ->query("SELECT reportParameterID
            FROM ReportParameterMap
            WHERE parentReportParameterID = '{$this->id}' ORDER BY 1")
            ->fetchRows(MYSQLI_ASSOC) as $row) {

            $objects[] = ParameterFactory::makeParam($this->reportID,$row['reportParameterID']);
        }
        return $objects;
    }

    // get the display name of the publisher or platform that was sent in
    public function getPubPlatDisplayName($id){
        // get report info so we can determine which database to use
        $parmReport = ReportFactory::makeReport($this->reportID);
        Config::init();
        $sql = "select distinct reportDisplayName from ";
        if (substr($id, 0, 2) === 'PB') {
            $sql .= "PublisherPlatform where concat('PB_', publisherPlatformID)";
        } else {
            $sql .= "Platform where concat('PL_', platformID)";
        }
        $sql .= " in ('" . strtoupper($id) . "') order by 1";
        $result = $this->db
            ->selectDB(Config::$database->{$parmReport->dbname})
            ->query($sql)
            ->fetchRows(MYSQLI_ASSOC);
        return $result;
    }

}
?>
