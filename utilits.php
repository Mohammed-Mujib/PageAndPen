<?php
    // ------------------
    // don't ever delete this folder or anything in it
    // ------------------
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $errors = [];
    session_start();
    if (is_authenticated()) {
        $user= $_SESSION["active"];
    }
    // print the old value of a form
    function have_Old ($val_name, $submitBtn) {
        if (isset($_POST[$submitBtn]) && isset($_POST[$val_name])) {
            echo 'value = "' . $_POST[$val_name] . '"';
        }
    }   
    // check if a specific fild have data
    function check_send ($submitBtn, $field_name, $alert_message = "This field is required"){
        if (isset($_POST[$submitBtn])){
            if (!$_POST[$field_name]) {
                echo '<div class="alert alert-danger py-0 my-1" ><p class = "m-0 p-2">' . $alert_message . '</p></div>';
            }
        }
    }
    function check_form_only ($submitBtn,...$fields){
        if(!empty($fields)){
            if (isset($_POST[$submitBtn])){
                foreach($fields as $val_name){
                    if(htmlspecialchars($_POST[$val_name]) == ""){
                        setErrorDirect($val_name);
                    }
                }
            }
        }
    }
    function check_form_all ($submitBtn){
        global $errors;
        if (isset($_POST[$submitBtn])){
            foreach($_POST as $val_name => $val){
                if(! ($val_name == $submitBtn)){
                    continue;
                }
                if(htmlspecialchars($val) == ""){
                        $errors[$val_name] ="This field is required";
                }
            }
        }
    }
    function setErrorDirect( $error_name, $error_message="This field is required" ){
        global $errors;
        if (!empty($error_name)) {
            $errors[$error_name] = $error_message;
        }
    }
    //set an error
    // function set_error( $var, $error_name, $error_message="This field is required" ){
    //     global $errors;
    //     if ($var === "") {
    //         $errors[$error_name] = $error_message;
    //     }
    // }
    function set_error($error_name, $var = "", $error_message = "This field is required") {
        global $errors;
        if ($var === "") { // Ensures the variable is empty before setting an error
            $errors[$error_name] = $error_message;
        }
    }

    //print an error by name
    function show_errors ($error_name){
        global $errors;
        if(isset($errors[$error_name])){
            echo '<div class=" p-1 mt-0 mb-0" ><small class = "p-2 text-capitalize text-danger"> ' . $errors[$error_name] . '</small></div>';
        }
    }
    // delete directory and it's files 
    function deleteDirectory($dir) {
        if (!is_dir($dir)) {
            return false;
        }

        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            is_dir($path) ? deleteDirectory($path) : unlink($path);
        }

        return rmdir($dir);
    }
    //check if the page name the same as a given name
    function is_page($file_name){
        return basename($_SERVER["PHP_SELF"]) === $file_name;
    }
    function login($user){
        session_start();
        $_SESSION["active"]= $user;
    }
    function is_authenticated(): bool {
        return isset($_SESSION["active"]);
    }
    function is_admin(): bool {
        return ($_SESSION["active"]["role"] ?? '') === "admin";
    }
    function authorize(): void {
        if (!is_authenticated()) {
            header('Location: login.php');
            exit();
        }
        if (is_admin()) {
            header('Location: Admin/dashboard.php');
        } else {
            header('Location: index.php');
        }
        exit();
    }

    function logout(): void {
        session_unset();
        session_destroy();
    }
    function redirect_auth_user(): void {
        if (is_authenticated()) {
            $redirect_url = is_admin() ? 'Admin/dashboard.php' : 'index.php';
            header("Location: $redirect_url");
            exit();
        }
        
    }
    
    function arrayClean_print($arrey){
        echo "<pre>";
            print_r($arrey);
        echo "</pre> <br>";
    }
?>