<?php

require_once 'koneksi.php';
require_once 'function.php';

$user_id = $_GET['id'];

$roles = getRoles();

$dataUser = mysqli_fetch_array(getUserDetail($user_id));

function editUser($id, $name, $role, $password, $email, $phone, $address)
{
    global $conn, $dataUser;

    
    if($_FILES['avatar']['name'] != ''){
        unlink($dataUser['avatar']);
        $namaFile = $_FILES['avatar']['name'];
        $path = './upload/'.$namaFile;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
    }else{
        $path = $dataUser['avatar'];
    }

    $query = "UPDATE users SET name='$name', role_id='$role', email='$email', password='$password', phone='$phone', address='$address', avatar='$path'  WHERE id = '$id'";
    if(mysqli_query($conn, $query)){
        echo "Data berhasil diupdate";
        header("Location: index.php");
    }else{
        echo "Gagal";
    }
    
}
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    editUser($user_id, $name, $role, $password, $email, $phone, $address);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />

</head>
<body>
   


<div class="p-4">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
    
   <h1 class="text-3xl font-bold text-center mb-8 ">Edit Users</h1>
   <div class="">
   <form action="edit.php?id=<?=$user_id?>" method="POST" enctype="multipart/form-data">
                <div class="mb-6">
                    <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                    <input type="text" id="text" name="name" value="<?=$dataUser['name']?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="namamu..." required>
                </div>
                <div class="mb-6 flex gap-2">   
                    <div class="w-1/2">
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <!-- <option selected>Pilih Role</option> -->
                            <?php while($row = mysqli_fetch_array($roles)) : ?>
                            <?php if($row['id'] == $dataUser['role_id']) : ?>    
                                <option selected value=<?=$row['id'];?>><?= $row['name'];?></option>
                            <?php else:?>
                                <option value=<?=$row['id'];?>><?= $row['name'];?></option>
                            <?php endif;?>
                            <?php endWhile;?>
                        </select>
                    </div>       
                    <div class="w-1/2">
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" id="password" name="password" value="<?=$dataUser['password']?>"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="password..." required>
                    </div>
                </div>
                <div class="mb-6 flex gap-2">   
                    <div class="w-1/2">
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" id="email" name="email" value="<?=$dataUser['email']?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="example@gmail..." required>
                    </div>
                    <div class="w-1/2">
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telepon</label>
                        <input type="number" id="phone" name="phone" value="<?=$dataUser['phone']?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="085..." required>
                    </div>
                </div>
                <div class="mb-6">        
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                    <textarea id="address" name="address" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="indonesia..."><?=$dataUser['address']?></textarea>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Unggah Foto</label>
                    <input name="avatar" class="block w-full mb-2 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">
                    
                    <img class=" rounded-lg mx-auto h-24 w-24" src="<?= $dataUser['avatar']?>" alt="image description">

                </div>
                <button type="submit" name="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>

   </div>
      
   </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>
</html>