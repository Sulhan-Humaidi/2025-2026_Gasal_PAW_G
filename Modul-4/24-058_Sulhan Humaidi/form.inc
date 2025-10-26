<form action="index.php" method="POST">
    
    <label for="fname">Nama Depan:</label>
    <input type="text" id="fname" name="firstname" 
           value="<?php echo htmlspecialchars($_POST['firstname'] ?? ''); ?>">
    
    <br><br>
    
    <label for="sname">Nama Belakang (Surname):</label>
    <input type="text" id="sname" name="surname"
           value="<?php echo htmlspecialchars($_POST['surname'] ?? ''); ?>">
    
    <br><br>
    
    <input type="submit" value="Submit">
    
</form>