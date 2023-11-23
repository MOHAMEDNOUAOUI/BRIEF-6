if(isset($_POST['ADDCATEGORY'])) {
            //add category
            $CG = $_POST['ADDCATEGORY'];

            $cate = $cnc->prepare("INSERT INTO category (NAMEcategory) values ($CG);");
            $cate->execute();
        }