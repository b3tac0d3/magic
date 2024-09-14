<?php 

namespace Aces;
use PDO;
use PDOException;

class Query extends Db{
    
    /*==================================================================================================================
        Variables
    ==================================================================================================================*/

    // Main Table name | string
    private $Table;

    // Main Table Alias | string 
    private $Alias;
    
    // Column list ready for Query string | string | code generated
    private $Columns;

    // List of Columns maintained throughout run for updating column list string | string
    private $ColumnsList;

    // Querty string join statment | string
    private $JoinStmt;

    // Execute array join values | array
    private $JoinsArray;

    // Query string where statement | string
    private $WhereStmt;

    // Execute array where values | array
    private $WhereArray;
    
    // Primary Grouping | string
    private $Group;
    
    // Primary Ordering | string
    private $Order;
    
    // Start and Limit | string
    private $Limit;
    
    // PDO::Fetch type
    private $Execute = array();
    
    // PDO Fetch mode | command
    private $Fetch;
    
    // MySQL Results array
    private $Results;
    
    // Boolean to return single top row or multiple rows
    private $FetchSolo;
    
    // Complete Query string to be Executed | string
    private $QueryString;
    
    // PDO Query method | object
    private $Query;

    // Type of Query currently being setup to Execute | string
    private $QueryType;

    // List of values to be inserted | string
    private $InsertList;

    // Insert values ready to be added to prepared statement | string
    private $InsertSqlString;

    // Last insert id as generated by PDO | int
    private $LastInsertId;

    // Query rowCount()
    private $RowCount;

    // Class stored as new class
    private $ErrorHandler;

    // Log class
    private $Log;

    // Databse object
    private $Db;

    /*==================================================================================================================
        Logging
    ==================================================================================================================*/

    private $QueryStartTime;

    private $QueryEndTime;

    private $QueryRunTime;

    /*==================================================================================================================
        Debug vars
    ==================================================================================================================*/

    // Switch to check if DebugMe should be checked
    private $DebugMode = false;
    
    // Show current Query string instead of executing
    private $ShowMyQueryString;

    // Stop after debug options have been Executed
    private $DebugStopMode = false;

    // Return string containing all requested debug values
    private $Debugged;

    /*==================================================================================================================
        Query Methods
    ==================================================================================================================*/

    function __construct(){
        $this -> Db = $this -> Connect();
        //$this -> ErrorHandler = new load_errors();
        $this -> Log = new Log();
        $this -> SetFetch();
    } // __construct()

    function Select($Table, $Alias = null){
        $this -> QueryType = "Select";
        $this -> Alias = $Alias;
        return $this -> RunSelectQuery($Table);
    } // select()

    function Insert($Table, $AuditTableLogNote = null){
        $this -> QueryType = "Insert";
        return $this -> RunInsertQuery($Table, $AuditTableLogNote);
    } // insert()

    function Update($Table){
        $this -> QueryType = "Update";
        return $this -> RunUpdateQuery($Table);
    } // update()

    function Delete($Table){
        $this -> QueryType = "Delete";
        return $this -> RunDeleteQuery($Table);
    } // delete()

    function Deactivate($Table, $RowId){
        // This function is specifically designed to deactivate rows and Log the delete while keeping the record
        // Consider this a "soft delete"
        $this -> QueryType = "Deactivate";
        return $this -> RunDeactivateQuery($Table, $RowId);
    } // deactivate()

    function Custom($Query, $Params = array()){
        $this -> QueryString = $Query;
        $this -> Execute = $Params;
        $this -> Query -> Execute($this -> Execute);
        $this -> Results = $this -> Query -> FetchAll($this -> Fetch);
        $this -> LastInsertId = $this -> Db -> LastInsertId();
        return $this -> Results;
    } // custom()

    /*==================================================================================================================
        Query Setup
    ==================================================================================================================*/

    function SetJoin($Table, $Alias = null, $OnsArray = array(), $Type = "INNER"){
        /* on_vals array should be array("u.id = l.user_id", ) */

        // Check / set where-Execute-array if not exists
        if(empty($this -> JoinsArray)) $this -> JoinsArray = array();
        if(empty($OnsArray)) $this -> ErrorHandler -> mk_error("dev", "Function SetJoin of database/Query.php file is missing comparison values. Check use of input function.");
        if(empty($Ons)) $Ons = "";

        foreach($OnsArray as $k => $v){
            $Ons .= "$k = $v";
            // if(!empty($v)) array_push($this -> JoinsArray, $on[1]);
            if(next($OnsArray)) $Ons .= "AND ";
        }
        // find non-relational on conditions and bind to Execute array
        $this -> JoinStmt .= "$Type JOIN $Table $Alias ON $Ons ";
        
        return $this;
    } // SetJoin()

    function SetWhere($Column, $Value, $Operator = "=", $LogicalOperator = "AND "){
        
        if(empty($this -> WhereStmt)){
            $this -> WhereStmt = "WHERE ";
        }else{
            $this -> WhereStmt = $this -> WhereStmt . "$LogicalOperator ";
        }

        if(empty($this -> WhereArray)) $this -> WhereArray = array();

        $WhereFactor = "? ";
        
        // If value is an array, it's either for BETWEEN or IN statement
        if(!is_array($Value)) $Value = explode(",", $Value);

        if($Operator == "BETWEEN"){
            $WhereFactor = "? AND ? ";
            array_push($this -> WhereArray, $Value[0], $Value[1]);
        }elseif($Operator == "IN"){
            $WhereFactor = "(". join(',', array_fill(0, count($Value), '?')) . ")";
            $this -> WhereArray = array_merge($this -> WhereArray, $Value);
        }else{
            array_push($this -> WhereArray, $Value[0]);
        }
        
        $this -> WhereStmt .= "$Column $Operator $WhereFactor";
        
        return $this;
    } // SetWhere()

    function SetWhereArray($Columns, $Values){
        // Push an array of where statements but only for = operator
        // Alternative statements with BETWEEN or IN will still have to be set individually
        foreach($Columns as $k => $v) $this -> SetWhere($v, $Values[$k]);
        return $this;
    }

    function SetGroup($Column){
        if(empty($this -> Group)){
            $this -> Group = "Group BY ";
        }else{
            $this -> Group = "," . $this -> Group;
        }
        $this -> Group .= $Column;
        return $this;
    } // SetGroup()

    function SetOrder($Column, $Order){
        if(empty($this -> Order)){
            $this -> Order = "Order BY ";
        }else{
            $this -> Order = "," . $this -> Order;
        }
        if(empty($sort = $Order)) $sort = "ASC ";
        $this -> Order .= "$Column $sort ";
        return $this;
    } // set_sort()

    function SetLimit($start, $Limit){
        $this -> Limit = "Limit $start, $Limit";
        return $this;
    } // SetLimit()
    
    function SetSelectColumn($Column = null){
        if(empty($Column)){
            $this -> Columns = "*";
        }else{
            if(!empty($this -> Columns)) $this -> Columns .= ",";
            $this -> Columns .= $Column;
        }
        return $this;
    } // SetSelectColumns()

    function SetSelectArray($Columns){
        foreach($Columns as $c){
            $this -> SetSelectColumn($c);
        }
        return $this;
    } // SetSelectArray

    function SetUpdateColumn($Column, $Value = null){
        if(!empty($this -> ColumnsList)) $this -> ColumnsList .= ",";
        if(!empty($this -> InsertList)) $this -> InsertList .= ",";
        
        $this -> ColumnsList .= "$Column = ?";

        array_push($this -> Execute, $Value);
        
        $this -> Columns = "{$this -> ColumnsList}";
        return $this;
    } // SetUpdateColumns()

    function SetUpdateArray($Columns, $Values){
        // The key difference is that this accpets multiple values as arrays
        // Columns = arry and values = array
        // These are associative based on key (ie cols = user, pass, active ?? vals = user, pass, 1)

        foreach($Columns as $Key => $Value) $this -> SetUpdateColumn($Value, $Values[$Key]);

        return $this;
    } // SetUpdateColumns()

    function SetInsertColumn($Column, $Value=null){
        // INSERT INTO {$this -> Table} {$this -> Columns} VALUES {$this -> InsertSqlString}
        // $this -> InsertSqlString must be surrounded by parenthases - reset every time something is added to InsertList
        // $this -> InsertList maintains a running list of question marks to represent variables in Execute_array
        
        if(!empty($this -> ColumnsList)) $this -> ColumnsList .= ",";
        if(!empty($this -> InsertList)) $this -> InsertList .= ",";
        
        $this -> ColumnsList .= $Column;
        $this -> InsertList .= "?";

        array_push($this -> Execute, $Value);
        
        $this -> Columns = "({$this -> ColumnsList})";
        $this -> InsertSqlString = "({$this -> InsertList})";
        
        return $this;
    } // SetInsertColumn()

    function SetInsertArray($Columns, $Values){
        // The key difference is that this accpets multiple values as arrays
        // Columns = arry and values = array
        // These are associative based on key (ie cols = user, pass, active ?? vals = user, pass, 1)

        foreach($Columns as $Key => $Value) $this -> SetInsertColumn($Value, $Values[$Key]);

        return $this;
    } // SetInsertColumns()

    function SetAlias($Alias){
        $this -> Alias = $Alias;
        return $this;
    } // SetAlias()

    function SetFetch($FetchSolo = 0, $Fetch = PDO::FETCH_ASSOC){
        // Default is to return all records
        // Return all records or just a single record
        if($FetchSolo == 0)
            $this -> FetchSolo = false;
        else
            $this -> FetchSolo = true;

        // Set the PDO Fetch type. Accepts all values
        $this -> Fetch = $Fetch;

        return $this;
    } // set_return()

    function DevDebug($Type, $Stop = true){
        if($Stop == true) $this -> DebugStopMode = true;
        $this -> DebugMode = true;
        
        switch($Type){
            case "show_QueryString":
            case "SQS": // ShowQueryString
                $this -> ShowMyQueryString = true;
                break;
        }
    } // DevDebug()

    function GetLastInsertId(){
        return $this -> LastInsertId;
    } // GetLastInsertId()


    function GetResults(){
        return $this -> Results;
    } // GetResults()

    function GetRowCount(){
        return $this -> RowCount;
    } // GetRowCount()

    /*==================================================================================================================
        Class Control Methods
    ==================================================================================================================*/

    private function RunSelectQuery($Table){
        // Prepare Query and do pre-checks
        $this -> PreQuery($Table);
        
        // If no Columns were entered, default to all Columns
        if(empty($this -> Columns)) $this -> SetSelectColumn();
        
        // Prepare the proper Query string
        $this -> QueryString = "SELECT {$this -> Columns} FROM {$this -> Table} {$this -> Alias} {$this -> JoinStmt} {$this -> WhereStmt} {$this -> Group} {$this -> Order} {$this -> Limit}";
        
        // Debugging
        // var_dump($this -> QueryString);exit;
        
        // Run Query
        $this -> ExecuteQuery();
        
        // Get the proper Results to return to user
        $this -> RowCount = $this -> Query -> rowCount();
        if($this -> FetchSolo == true){
            $this -> Results = $this -> Query -> Fetch($this -> Fetch);
        }else{
            $this -> Results = $this -> Query -> FetchAll($this -> Fetch);
        }

        return $this -> Results;
    } // RunSelectQuery()

    private function RunInsertQuery($Table, $AuditTableLogNote = null){
        // Prepare Query and do pre-checks
        $this -> PreQuery($Table);

        // If no Columns are set to insert, we can't continue
        if(empty($this -> Columns)) $this -> ErrorHandler -> mk_error("dev", "No values set to insert.");
        
        // Prepare the proper Query string
        $this -> QueryString = "INSERT INTO {$this -> Table} {$this -> Columns} VALUES {$this -> InsertSqlString}";
        
        // Run Query
        $this -> ExecuteQuery();

        // Get the proper Results to return to the user
        $this -> Results = array(
            "status" => 1,
            "last_insert_id" => $this -> Db -> LastInsertId()
        );

        // Get last insert id for Logging and Db record purposing
        $this -> LastInsertId = $this -> Db -> LastInsertId();

        // Add to database record Logs
        if(AcesDbRecordLoggingEdits == true && !str_contains($this -> Table, "log_")){
            // FOR NOW, THIS FEATURE IS SOLELY RELYING ON THE USE OF THE TERM "log_" TO DEFINE Log TableS.
            // IN THE FUTURE, CONSIDER CREATING A LIST OF Log TableS TO REFERENCE INSTEAD.
            $audit = new QueryAudits();
            $audit -> AuditDbRecordCreate($this -> Table, $this -> LastInsertId, $AuditTableLogNote);
        }

        return $this -> Results;
    } // RunInsertQuery

    private function RunUpdateQuery($Table){
        // Prepare Query and do pre-checks
        $this -> PreQuery($Table);

        // If no Columns are set to update, we can't continue
        if(empty($this -> Columns)) $this -> ErrorHandler -> mk_error("dev", "No values set to update.");

        // Prepare the proper Query string
        $this -> QueryString = "UPDATE {$this -> Table} SET {$this -> Columns} {$this -> WhereStmt}";

        // Run Query
        $this -> ExecuteQuery();

        // Get the proper Results to return to the user
        $this -> Results = array("status" => 1);
        
        return $this -> Results;
    } // RunUpdateQuery

    private function RunDeleteQuery($Table){
        // Prepare Query do do pre-checks
        $this -> PreQuery($Table);

        // Prepare the proper Query string
        $this -> QueryString = "DELETE FROM {$this -> Table} {$this -> WhereStmt}";

        // Run Query
        $this -> ExecuteQuery();

        // Get the proper Results to return to the user
        $this -> Results = array("status" => 1);
        
        return $this -> Results;
    } // RunDeleteQuery

    private function RunDeactivateQuery($Table, $RowId){
        // Prepare the proper Query string with the only where statement needed
        $this -> SetWhere("id", $RowId);

        // Prepare Query do do pre-checks
        $this -> PreQuery($Table);

        // Prepare the Query string
        $this -> QueryString = "UPDATE {$this -> Table} SET active = 0 {$this -> WhereStmt}";
        
        // Run Query
        $this -> ExecuteQuery();
        
        // Log the Results in the record life Table
        // DON'T FORGET TO ADD CHECKING FOR DATABASE LogGING TRUE TO BE ON
        $audit = new QueryAudits();
        $audit -> AuditDbRecordDelete($Table, $RowId);

        return $this -> Results;
    } // RunDeactivateQuery

    private function run_custom_Query($Table){
        
    }

    private function PreQuery($Table){
        // Absolute
        if(empty($this -> Table = $Table)) $this -> ErrorHandler -> mk_error("dev", "select Query has empty Table name");
        if(!empty($this -> JoinsArray)) $this -> Execute = array_merge($this -> Execute, $this -> JoinsArray);
        if(!empty($this -> WhereArray)) $this -> Execute = array_merge($this -> Execute, $this -> WhereArray);

        return $this;
    } // PreQuery()


    private function ExecuteQuery(){
        // Final prep on the Query string to translate to Query
        $this -> Query = $this -> Db -> prepare(trim($this -> QueryString));
        
        // Attempt to run final Query
        try{
            // Capture Query start time for tracking
            $this -> QueryStartTime = microtime(true);
            
            // Run Query
            $this -> Query -> Execute($this -> Execute);

            // Get Query run time
            $this -> QueryEndTime = microtime(true);
            $this -> QueryRunTime = $this -> QueryEndTime - $this -> QueryStartTime;

        }catch (PDOException $e){
            $this -> Log -> SetRecord("Query_error", [
                "error" => trim($e -> getMessage()),
                "QueryString" => preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $this -> DumpSqlQuery($this -> QueryString, $this -> Execute))
            ]);
            echo "<br><br><b><i>ACES Error</i>: " . $e -> getMessage() . "</b>";
            exit;
        } // try

        // Post Query Results handling and Query Logging
        $this -> RowCount = $this -> Query -> rowCount();

        // Log Query if applicable
        if(AcesLogStatusQuery == true && $this -> Table != "log_record_audit"){
            $LogDataArray = array(
                "Table" => $this -> Table,
                "ResultCount" => $this -> RowCount,
                "RunTime" => round($this -> QueryRunTime, 5) . "s",
                "QueryString" => preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $this -> DumpSqlQuery($this -> QueryString, $this -> Execute))
            );
            $this -> Log -> SetRecord("Query", $LogDataArray);
        }

        return $this;
    } // ExecuteQuery()

    /*==================================================================================================================
        Debugging
    ==================================================================================================================*/

    private function DebugMe(){
        if($this -> ShowMyQueryString == true) $this -> Debugged .= "<b>Final Query String: <i>" . $this -> Query . "</i></b><br>";
        echo $this -> Debugged;
        //if($this -> DebugStopMode == true) exit();
    } // DebugMe()


    private function DumpSqlQuery($string,$data) {
        $indexed = $data == array_values($data);
        foreach($data as $k => $v) {
            // These two line are to eliminate deprication errors for passing null values to second arg of preg_replace in PHP 8.1+
            if(empty($v) && is_string($v)) $v = "";
            if(empty($v)) $v = 0;
            
            if(is_string($v)) $v = "'$v'";
            if($indexed) $string = preg_replace('/\?/',$v,$string,1);
            else $string = str_replace(":$k",$v,$string);
        }
        return $string;
    }
} // class Query
?>