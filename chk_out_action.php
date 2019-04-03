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
        $chk_equip_id = check_equip_id_exists($connect, $_POST['equip_id']);
        $chk_avail = check_equip_availability($connect, $_POST['equip_id']);
        
        if($chk_equip_id == 'yes'){
        	if($_POST['site_id'] >= 303000){
	        	if($chk_avail){

		            $query = "
		            INSERT INTO equipment_checkout (equip_id, empl_id, site_id, chk_date_time) 
		            VALUES (:equip_id, :empl_id, :site_id, :chk_date_time);

		            UPDATE equipment
		            SET is_available = 'unavailable'
		            WHERE equip_id = '".$_POST['equip_id']."'
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
		            	echo '<div class="alert alert-success">Successfully checked out an item!</div>';
		            }else{
		            	echo '<div class="alert alert-danger">Something went wrong!</div>';
		            }
		        }else{
		        	echo'<div class="alert alert-danger">ERROR! This item is already in use!</div>';
		        }
		    }elseif ($_POST['site_id'] == 0) {
		    	echo '<div class="alert alert-danger">Please select a site!</div>';
		    }else{
		    	echo '<div class="alert alert-danger">The site you selected is incorrect, or no longer in operation!</div>';
		    }
        }else{

        	echo '<div class="alert alert-danger">'.$chk_equip_id.'</div>';
        }
    }
}

?>