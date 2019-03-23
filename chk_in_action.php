 <?php
 //chk_out_action.php
include('function.php');

/*
        Users are sent here after clicking a button or doing some action (like
    adding a user) on user.php. Below is the php, javascript, and SQL commands 
    called whenever someone performs one of those actions.
*/

include('database_connection.php');

if(isset($_POST['btn_action']))
{
    //  **********  Add button pressed  ********** 
    if($_POST['btn_action'] == 'chk_in_btn' )
    {
        //Makes sure the equip_id that the user is trying to check-out exists in the database and is available... If true, should return "yes", if false, should return error string.
        $equip_id_chk = check_equip_id_exists($connect, $_POST['equip_id']);
        
        

            $query = "
            DELETE FROM equipment_checkout
            WHERE chk_id = '"$_POST['chk_id']"'
            ";  
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    ':equip_id'         =>  $_POST["equip_id"],
                    ':empl_id'          =>  $_SESSION["user_id"],
                    ':site_id'          =>  $_POST["site_id"],
                    ':chk_date_time'    =>  date("Y-m-d h:i a")
                    
                )
            );

            //Verifying that the database was updated successfully
            $result = $statement->fetchAll();
            if(isset($result))
            {
                echo 'Successfully checked in an item!';
            }else{
                echo 'Something went wrong!';
            }
    }
}

?>