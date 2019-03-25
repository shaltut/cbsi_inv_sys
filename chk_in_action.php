 <?php
 //chk_out_action.php
include('function.php');

/*
        Users are sent here after clicking a button or doing some action (like
    adding a user) on user.php. Below is the php, javascript, and SQL commands 
    called whenever someone performs one of those actions.

 	404097, 202000
    404095, 202001
*/

include('database_connection.php');

if(isset($_POST['btn_action']))
{
    //  **********  Add button pressed  ********** 
    if($_POST['btn_action'] == 'chk_in_btn' )
    {   
            $query = "
            DELETE FROM equipment_checkout
            WHERE chk_id = '".$_POST['chk_id']."';

            UPDATE equipment
            SET is_available = 'available'
            WHERE equip_id = '".$_POST['status']."'
            "; 
            $statement = $connect->prepare($query);
            $statement->execute();

            //Verifying that the database was updated successfully
            $result = $statement->fetchAll();
            if(isset($result))
            {
                echo 'Successfully Returned an Item!';
            }else{
                echo 'Something Went Wrong!';
            }
    }
}

?>