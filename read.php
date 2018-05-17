<?php
 
include 'db.php'; // including connection file

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        $i = 0;
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $i++;
            
            if($i<=50000){ // checking conditions
                
                $check = mysql_query("SELECT * FROM employee WHERE account_number= '$column[0]' and amount = '$column[2]' and date = '$column[3]'");
                
                if(mysql_num_rows($check) === 0){
                    $sqlInsert = "INSERT into employee (account_number,name,amount,date)
                       values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "')";

                    $result = mysql_query($sqlInsert);

                    if (! empty($result)) {
                        $type = "success";
                        $message = "CSV Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing CSV Data";
                    }
                }
            }
            
        }
    }
}
?>
