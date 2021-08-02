<?php
ob_start();
require "../../../helpers/paths.php";
require "../../../helpers/functions.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';
require '../../../layout/navAdmin.php';



$errorMessages = [];




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $category  = cleanInputs(Sanitize($_POST['Category'], 2));



    //book cat validation

    if (!Validator($category, 1)) {

        $errorMessages['Category'] = "Write Category";
    }
    if (!Validator($category, 2)) {

        $errorMessages['Category'] = " Category Name must be more than 3";
    }


    if (count($errorMessages) > 0) {

        $_SESSION['errmessages'] = $errorMessages;
    } else {

        $sql = "insert into bookscategory (book_category) values ('$category')";
        $ops =  mysqli_query($con, $sql);



        if ($ops) {

            $_SESSION['message'] = "Category Adder";
            header("Location: " . resources('booksCategory/index.php'));
        } else {
            $errorMessages['Category'] = "Error in Your Sql Try Again";
        }


        $_SESSION['errmessages'] = $errorMessages;
    }
}







?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding user Category </title>
    <link rel="stylesheet" href="<?php echo css('create.css') ?>">
</head>

<body class="col-12">

    <h1 class="text-danger">Add a new Book Category
        <small>Add Category </small>
    </h1>

    <ol class="breadcrumb bg-gradient bg-dark p-2 mx-auto mt-5 w-50 ">
        <li class="breadcrumb-item"><a class="text-decoration-none text-danger" href="<?php echo resources('booksCategory/index.php') ?>">Books Categories</a></li>
        <li class="breadcrumb-item active ">Add Category</li>
    </ol>

    <h4 class="bg-gradient bg-dark p-2 mx-auto mt-5 w-50 text-danger text-center">
        <?php
        if (isset($_SESSION['errmessages'])) {

            foreach ($_SESSION['errmessages'] as $key =>  $data) {

                echo '* ' . $key . ' : ' . $data . '<br>';
            }

            unset($_SESSION['errmessages']);
        } else {
            echo "Fill the inputs Please!";
        }
        ?>
    </h4>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="  col-8 mx-auto mt-5 d-flex align-items-center flex-column  p-4 ps-0 " enctype="multipart/form-data">


        <div class="col-12 col-lg-7 m-3 mx-auto">
            <div class=" form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Enter Category" name="Category">
                <label for="floatingInput">Enter Category</label>
            </div>
        </div>



        <input type="submit" class="btn btn-warning col-5 m-3 " value="Create">

    </form>


</body>

</html>