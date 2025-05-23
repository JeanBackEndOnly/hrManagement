<?php
header('Content-Type: application/json');
include './functions.php';
// require_once '../installer/session.php';

if ($_POST['action'] === 'save_installation_data') {
    $system_title = $_POST['system_title'];
    $system_description = $_POST['system_description'];

    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'administrator';

    if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/image/upload/';

        $uploadPath = $uploadDir . basename($_FILES['site_logo']['name']);

        if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $uploadPath)) {
            save_option('system_logo', basename($_FILES['site_logo']['name']));
        }
    }

    $passwordhash = password_hash($password, PASSWORD_DEFAULT);

    $user = save_user(array(
        'firstname' => $firstname,
        'middlename' => $middlename,
        'lastname' => $lastname,
        'email' => $email,
        'username' => $username,
        'password' => $passwordhash,
        'user_role' => $role,
    ));

    if (!$user['is_error']) {
        save_option('system_title', $system_title);
        save_option('system_description', $system_description);
        echo json_encode(array(
            'success' => true,
            'message' => 'Installation Complete'
        ));
        exit();
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Something went wrong please try again'
        ));
        exit();
    }
}
if($_POST['action'] === 'register-data'){
    $firstname = $_POST['Lname'];
    $lastname = $_POST['Fname'];
    $middlename = $_POST['Mname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($_FILES['user_profile']) && $_FILES['user_profile']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/image/upload/';

        $uploadPath = $uploadDir . basename($_FILES['user_profile']['name']);

        if (move_uploaded_file($_FILES['user_profile']['tmp_name'], $uploadPath)) {
            
        }
    }
}

if ($_POST['action'] === 'login') {
    $conn = db_connect();

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    try {
        // 1. Try logging in as employee (users table)
        $stmt = $conn->prepare("SELECT * FROM users
        INNER JOIN userrequest ON users.id = userrequest.users_id
        WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = 'employee';
            $_SESSION['status'] = $user['status'];
            $id = $_SESSION['user_id'];
            echo json_encode([
                'success' => true,
                'message' => 'Welcome employee!',
                'role' => 'employee',
                'status' => $user['status'],

            ]);
            date_default_timezone_set('Asia/Manila');
                $time = date("H:i:s");

            // INSERT login time
            $query = "INSERT INTO user_status (users_id, Logged_in) VALUES (:id, :Logged_in)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":Logged_in", $time);
            $stmt->execute();

            exit;
        }

        // 2. Try logging in as admin (admin table)
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            session_start();
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['user_role'] = 'admin';

            echo json_encode([
                'success' => true,
                'message' => 'Welcome admin!',
                'role' => 'admin'
            ]);
            exit;
        }

        // 3. If not found in either
        echo json_encode([
            'success' => false,
            'message' => 'Invalid username or password'
        ]);
        exit;

    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
        exit;
    }
}



// if($_POST['action'] === 'login'){
//     $conn = db_connect();

//     $username = isset($_POST['username']) ? trim($_POST['username']) : "";
//     $password = isset($_POST['password']) ? trim($_POST['password']) : "";

//     try {
//         $stmt = $conn->prepare("SELECT * FROM users WHERE username =?");
//         $stmt->execute([$username]);
//         $userLogin = $stmt->fetch(PDO::FETCH_ASSOC);

//         $stmt = $conn->prepare("SELECT * FROM admin WHERE username =?");
//         $stmt->execute([$username]);
//         $user = $stmt->fetch(PDO::FETCH_ASSOC);

//         if ($user) {
            
//             if (password_verify($password, $user['password'])) {
//                 session_start();
//                 $_SESSION['user_id'] = $user['id'];

//                 echo json_encode([
//                     'success' => true,
//                     'message' => 'Login successful'
//                 ]);
//                 exit;
//             } else {
//                 echo json_encode([
//                     'success' => false,
//                     'message' => 'Password incorrect'
//                 ]);
//                 exit;
//             }
//         } else if($userLogin){
//             if (password_verify($password, $userLogin['password'])){

//                 session_start();
//                 $_SESSION['user_id'] = $userLogin['id'];

//                 echo json_encode([
//                     'success' => true,
//                     'message' => 'Login successful'
//                 ]);
//                 exit;
//             } else {
//                 echo json_encode([
//                     'success' => false,
//                     'message' => 'Password incorrect'
//                 ]);
//                 exit;
//             }
//         }
//         else {
//             echo json_encode([
//                 'success' => false,
//                 'message' => 'No such username exists'
//             ]);
//             exit;
//         }

//     } catch (PDOException $e) {
//         echo json_encode([
//             'success' => false,
//             'message' => 'Database Error: ' . $e->getMessage()
//         ]);
//         exit;
//     }
// }


/*
if($_POST['action'] === 'add_category'){
    if(!isset($_POST['category_name'])){
        header("Location: " . base_url() . "categories.php?status=401");
    }
    $category_name = $_POST['category_name'];
    $category_name = add_category($category_name);

    if($category_name){
        header("Location: " . base_url() . "categories.php?status=200");
    }else{
        header("Location: " . base_url() . "categories.php?status=500");
    }
}

if($_POST['action'] === 'add_product'){
    if(!isset($_POST['product_name'])){
        header("Location: " . base_url() . "products.php?status=401");
    }
    $product_name = $_POST['product_name'];
    $product_cat = $_POST['product_cat'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $low_stock = $_POST['low_stock'];
    $supplier_info = $_POST['supplier_info'];

    $prod_id = add_product(array(
        'product_name' => $product_name,
        'product_cat' => $product_cat,
        'price' => $price,
        'stock' => $stock,
        'low_stock' => $low_stock ? $low_stock : 1,
        'supplier_info' => $supplier_info
    ));

    if($prod_id){
        $log_text = 'A product has been added. Product: ' . $product_name . ' ' . ( get_category($product_cat) ? get_category($product_cat)['category_name'] : '') . ' Price: ' . $price .  ',  Stock: ' . $stock . ' with a minimum stock before low ' . $low_stock;
        add_log('logs', array(
            'log_type' => 'product_added',
            'content' => $log_text
        ));
        header("Location: " . base_url() . "products.php?status=200");
    }else{
        header("Location: " . base_url() . "products.php?status=500");
    }
}

if($_POST['action'] === 'update_product'){
    if(!isset($_POST['product_id']) && !get_product($_POST['product_id'])){
        header("Location: " . base_url() . "products.php?status=401");
    }
    $id = $_POST['product_id'];
    $current_stock = get_product($id)['stock'];

    $product_cat = $_POST['product_cat'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $low_stock = $_POST['low_stock'];
    $supplier_info = $_POST['supplier_info'];

    $prod_id = update_product($id, array(
        'product_cat' => $product_cat,
        'price' => $price,
        'stock' => $stock,
        'low_stock' => $low_stock ? $low_stock : 1,
        'supplier_info' => $supplier_info
    ));

    if($prod_id){
        add_log('logs', array(
            'log_type' => 'product_update',
            'content' => 'The product has been updated. Product: ' . get_product($id)['product_name'] . (get_category(get_product($id)['product_cat']) ? ' - ' . get_category(get_product($id)['product_cat'])['category_name'] . ' ' : " ") . ($current_stock === $stock ? ' No changes on the stock' : ' The stock has changed from ' . $current_stock . ' to ' . $stock)
        ));
        header("Location: " . base_url() . "products.php?status=200");
    }else{
        header("Location: " . base_url() . "products.php?status=500");
    }
}

if($_POST['action'] === 'delete_product'){
    if(!isset($_POST['product_id'])){
        header("Location: " . base_url() . "products.php?status=401");
    }
    $id = $_POST['product_id'];
    delete_product($id);
    header("Location: " . base_url() . "products.php?status=200");
 
}


if($_POST['action'] === 'delete_category'){
    if(!isset($_POST['category_name'])){
        header("Location: " . base_url() . "categories.php?status=401");
    }
    $id = $_POST['id'];
    $id = delete_category($id);
    header("Location: " . base_url() . "categories.php");

}

if($_POST['action'] === 'add_vendor'){
    if(!isset($_POST['branch'])){
        header("Location: " . base_url() . "vendors.php?status=401");
    }
    $branch = $_POST['branch'];
    $employee = $_POST['employee'];
    $contact_information = $_POST['contact_information'];
    $prod_id = add_vendor(array(
        'branch' => $branch,
        'employee' => $employee,
        'contact_information' => $contact_information,

    ));

    if($prod_id){
        header("Location: " . base_url() . "vendors.php?status=200");
    }else{
        header("Location: " . base_url() . "vendors.php?status=500");
    }
}
if($_POST['action'] === 'delete_vendor'){
    if(!isset($_POST['vendor_id'])){
        header("Location: " . base_url() . "vendors.php?status=401");
    }
    $id = $_POST['vendor_id'];
    delete_vendor($id);
    header("Location: " . base_url() . "vendors.php?status=200");
 
}


if($_POST['action'] === 'update_vendor'){
    if(!isset($_POST['vendor_id'])){
        header("Location: " . base_url() . "vendors.php?status=401");
    }
    $id = $_POST['vendor_id'];

    $branch = $_POST['branch'];
    $employee = $_POST['employee'];
    $contact_information = $_POST['contact_information'];

    $prod_id = update_vendor($id, array(
        'branch' => $branch,
        'employee' => $employee,
        'contact_information' => $contact_information,
    ));

    if($prod_id){
        header("Location: " . base_url() . "vendors.php?status=200");
    }else{
        header("Location: " . base_url() . "vendors.php?status=500");
    }
}

if($_POST['action'] === 'add_inout_logs'){
    if(!isset($_POST['vendor']) && !isset($_POST['product'])){
        header("Location: " . base_url() . "in-out.php?status=401");
    }
    $product = get_product($_POST['product']);
    if(empty($product)){
        header("Location: " . base_url() . "in-out.php?status=401");
    }
    $vendor = $_POST['vendor'];
    $current_stock = $product['stock'];
    $quantity = $_POST['quantity'];
    $in_out_type = $_POST['in_out_type'];
    $product_name = $product['product_name'] . (get_category($product['product_cat']) ? ' - ' . get_category($product['product_cat'])['category_name'] : "");
    $log_id = add_log('in_out', array(
        'vendor' => $vendor,
        'product' => $product_name,
        'price' => $product['price'],
        'quantity'  => $quantity,
        'total' => $product['price'] * $quantity,
        'updated_stock' => ( $in_out_type === 'in' ? $product['stock'] + $quantity : $product['stock'] - $quantity),
        'in_out_type' => $in_out_type
    ));
    if($log_id){
        if($in_out_type === 'in'){
            $prod_id = update_product($product['id'], array(
                'stock' => $product['stock'] + $quantity
            ));
            if($prod_id){
                add_log('logs', array(
                    'log_type' => 'product_update',
                    'content' => 'The product has been updated. Product: ' . $product['product_name'] . ' ' . ' The stock has changed from ' . $current_stock . ' to ' . ($product['stock'] + $quantity)
                ));

                header("Location: " . base_url() . "in-out.php?status=200");

            }
        }else{
            $prod_id = update_product($product['id'], array(
                'stock' => $product['stock'] - $quantity
            ));
            if($prod_id){
                add_log('logs', array(
                    'log_type' => 'product_update',
                    'content' => 'The product has been updated. Product: ' . $product['product_name'] . ' ' . ' The stock has changed from ' . $current_stock . ' to ' . ($product['stock'] - $quantity)
                ));

                header("Location: " . base_url() . "in-out.php?status=200");

            }
        }
    }else{
        header("Location: " . base_url() . "in-out.php?status=500");
    }
}


if($_POST['action'] === 'add_sales_logs'){
    if(!isset($_POST['vendor']) && !isset($_POST['product'])){
        header("Location: " . base_url() . "sales.php?status=401");
    }
    $product = get_product($_POST['product']);
    if(empty($product)){
        header("Location: " . base_url() . "sales.php?status=401");
    }
    $vendor = $_POST['vendor'];
    $current_stock = $product['stock'];
    $quantity = $_POST['quantity'];
    $sales_date = $_POST['sales_date'];
    $product_name = $product['product_name'] . (get_category($product['product_cat']) ? ' - ' . get_category($product['product_cat'])['category_name'] : "");
    $log_id = add_log('sales', array(
        'vendor' => $vendor,
        'product' => $product_name,
        'price' => $product['price'],
        'quantity'  => $quantity,
        'total' => $product['price'] * $quantity,
        'sales_date'  => $sales_date,
    ));
    if($log_id){
       

        add_log('logs', array(
            'log_type' => 'product_update',
            'content' => 'New Sales for Product: ' . $product['product_name'] . ' ' . ' with Total Sales ' . ($product['price'] * $quantity) . ' for the date ' . $sales_date
        ));
        header("Location: " . base_url() . "sales.php?status=200");
    }else{
        header("Location: " . base_url() . "sales.php?status=500");
    }
}



if($_POST['action'] === 'save_settings'){
    session_start();
    $system_title = $_POST['system_title'];
    $system_description = $_POST['system_description'];

    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    save_option('system_title', $system_title);
    save_option('system_description', $system_description);
    $user = save_user(array(
        'firstname' => $firstname,
        'middlename' => $middlename,
        'lastname' => $lastname,
        'email' => $email,
        'username' => $username,
        'password' => $password,
    ), $_SESSION['user_id']);

    if(!$user['is_error']){
        header("Location: " . base_url() . "settings.php?status=200");
        exit();
    }else{
        header("Location: " . base_url() . "settings.php?status=500");
        exit();
    }
} */