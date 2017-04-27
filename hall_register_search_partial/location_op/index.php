<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
.select-boxes{width: 280px;text-align: center;}
select {
    background-color: #F5F5F5;
    border: 1px double #FB4314;
    color: #55BB91;
    font-family: Georgia;
    font-weight: bold;
    font-size: 14px;
    height: 39px;
    padding: 7px 8px;
    width: 250px;
    outline: none;
    margin: 10px 0 10px 0;
}
select option{
    font-family: Georgia;
    font-size: 14px;
}
</style>
<script src="../js/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#country').on('change',function(){
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type: 'POST',
                url: '../common/location_ajaxData.php',
                data: 'country_id='+countryID,
                success:function(html){
                    $('#state').html(html);
                    $('#city').html('<option value="">Select state first</option>');
                }
            });
        }else{
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
    
    $('#state').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url:'../common/location_ajaxData.php',
                data:'state_id='+stateID,
                success:function(html){
                    $('#city').html(html);
                }
            }); 
        }else{
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
});
</script>
</head>
<body>
	<form action="register_hall.php" method="POST">
    <div class="select-boxes">
    <?php
    //Include database configuration file
	require_once(join("//", array(dirname(dirname(__FILE__)), 'common', 'lib_functions.php')));
	require_once(join("//", array(dirname(dirname(__FILE__)), 'common', 'db_connect.php')));
    
    //Get all country dataebe
    $select_query = "SELECT * FROM countries ORDER BY name ASC";
	$stmt = $db_handle->prepare($select_query);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	unset($stmt);

    ?>

	<label style="left-align"> Fill Location Details Below </label>
    <select name="country" id="country">
        <option value="">Select Country</option>
        <?php
            foreach($rows as $row){ 
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
        ?>
    </select>
    
    <select name="state" id="state">
        <option value="">Select country first</option>
    </select>
    
    <select name="city" id="city">
        <option value="">Select state first</option>
    </select>
	
	More Location Details: <textarea id="location_details" rows="4" cols="40" name="address_details"></textarea>
	<br/><br/>
	Hall Owner : <input type="text" name="hall_owner"><br/><br/>
	Contact No : <input type="text" name="hall_owner_contact"><br/><br/>
	Email Addr : <input type="text" name="hall_owner_email"><br/><br/>
	
	<input type="submit" value="Register Hall">
    </div>
	</form>
</body>
</html>
