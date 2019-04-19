<?php
/*  PAGE:   chk_in_action.php
*   INFO:   This page is used to complete an action after the user submits 
*           a form, clicks a button, or performs some other action. In this
*           case, there is only 1 possible action (clicking the check-in button)
*   ACTIONS:
*       chk_in_btn: Triggered when the check-in button is clicked on the table 
*                   in check.php. The chk_id of the checkout selected is sent 
*                   as well, and is used to tell this action which checkout
*                   to return.
*
*                   The action then takes the chk_id and sets the 'returned' 
*                   value in the database to 'true'.
*                   
*/

//Includes connection to the database
include('database_connection.php');

if(isset($_POST['btn_action']))
{
    //  **********  Add button pressed  ********** 
    if($_POST['btn_action'] == 'chk_in_btn' )
    {   
            $query = "
            UPDATE equipment_checkout
            SET returned = 'true'
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