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
    if($_POST['btn_action'] == 'Check Out' )
    {
        //Makes sure the equip_id that the user is trying to check-out exists in the database and is available... If true, should return "yes", if false, should return error string.
        $equip_id_chk = check_equip_id_exists($connect, $_POST['equip_id']);
        
        
        if($equip_id_chk == 'yes'){

            $query = "
            INSERT INTO equipment_checkout (equip_id, empl_id, site_id, chk_date_time) 
            VALUES (:equip_id, :empl_id, :site_id, :chk_date_time)
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
                echo 'Successfully checked out an item!';
            }else{
                echo 'Something went wrong!';
            }
        }else{
            echo $equip_id_chk;
        }
    }
    // if($_POST['btn_action'] == 'fetch_single')
    // {
    //     $query = "
    //     SELECT * FROM user_details WHERE user_id = :user_id
    //     ";
    //     $statement = $connect->prepare($query);
    //     $statement->execute(
    //         array(
    //             ':user_id'  =>  $_POST["user_id"]
    //         )
    //     );

    //     //Verifying that the database was updated successfully
    //     $result = $statement->fetchAll();
    //     foreach($result as $row)
    //     {
    //         $output['user_email'] = $row['user_email'];
    //         $output['user_name'] = $row['user_name'];
    //         $output['user_job'] = $row['user_job'];
    //     }
    //     echo json_encode($output);
    // }

    // //  **********  Update button pressed (for any user ac) ********** 
    // if($_POST['btn_action'] == 'Edit')
    // {
    //     if($_POST['user_password'] != '')
    //     {
    //         $query = "
    //         UPDATE user_details SET 
    //             user_name = '".$_POST["user_name"]."', 
    //             user_job = '".$_POST["user_job"]."',
    //             user_email = '".$_POST["user_email"]."',
    //             user_password = '".password_hash($_POST["user_password"], PASSWORD_DEFAULT)."' 
    //             WHERE user_id = '".$_POST["user_id"]."'
    //         ";
    //     }
    //     else
    //     {
    //         $query = "
    //         UPDATE user_details SET 
    //             user_name = '".$_POST["user_name"]."',
    //             user_job = '".$_POST["user_job"]."', 
    //             user_email = '".$_POST["user_email"]."'
    //             WHERE user_id = '".$_POST["user_id"]."'
    //         ";
    //     }
    //     $statement = $connect->prepare($query);
    //     $statement->execute();

    //     //Verifying that the database was updated successfully
    //     $result = $statement->fetchAll();
    //     if(isset($result))
    //     {
    //         echo 'User Details Edited';
    //     }
    // }

    // //  **********  Delete button pressed (for any user ac) ********** 
    // if($_POST['btn_action'] == 'disable')
    // {

    //     $status = 'Active';
    //     if($_POST['status'] == 'Active')
    //     {
    //         $status = 'Inactive';
    //     }
    //     $query = "
    //     UPDATE user_details 
    //     SET user_status = :user_status 
    //     WHERE user_id = :user_id
    //     ";
    //     $statement = $connect->prepare($query);
    //     $statement->execute(
    //         array(
    //             ':user_status'  =>  $status,
    //             ':user_id'      =>  $_POST["user_id"]
    //         )
    //     );  

    //     //Verifying that the database was updated successfully
    //     $result = $statement->fetchAll();   
    //     if(isset($result))
    //     {
    //         echo 'User Status change to ' . $status;
    //     }
    // }
}

?>