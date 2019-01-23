<title>Checkboxes</title>

<?php
    /// READY
    
    // Initialize variables
    $tired = isset($_REQUEST['tired']) ? $_REQUEST['tired'] : '';
    $headache = isset($_REQUEST['headache']) ? $_REQUEST['headache'] : '';
    $friday = isset($_REQUEST['friday']) ? $_REQUEST['friday'] : '';
    $check_array = is_checked($tired, $headache, $friday);

    make_form($tired, $headache, $friday, $check_array);


    // Test what checkboxes are checked and put results to array
    function is_checked($tired, $headache, $friday) {
        $check_array = array($tired, $headache, $friday);
        foreach ($check_array as &$value) {
            if ($value != '') $value = 'checked';
        }

        return $check_array;
    }

    // Makes form with 3 checkboxes and print their values if checked
    function make_form($tired, $headache, $friday, $check_array) {
    ?>
        <form method="post" action="h2t1.php">
        <p><label for="tired"><input type="checkbox" name="tired" value="I am tired. " onchange="this.form.submit()" <?php echo $check_array[0]; ?>>I am tired</label></p>
        
        <p><label for="headache"><input type="checkbox" name="headache" value="I have headache. " onchange="this.form.submit()" <?php echo $check_array[1]; ?>>I have headache</label></p>
        
        <p><label for="friday"><input type="checkbox" name="friday" value="It is friday!" onchange="this.form.submit()" <?php echo $check_array[2]; ?>>It iss friday</label></p>
        </form>
    
        <h2><?php echo $tired . $headache . $friday; ?></h2>
    <?php
    }
?>
</body>
</html>