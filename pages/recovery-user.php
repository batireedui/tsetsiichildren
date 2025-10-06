<?php
if(!isset($_POST["role"]))
{
    redirect("/");
}
else
{
    $role = trim(post('role', 100));
    $email = trim(post('email', 100));
    $newpass = rand(1001, 9999);
    if($role == "najiltan" || $role == "teacher" || $role == "admin")
    {
         if($role == "admin") $role = "users";
         if($role == "teacher") $role = "teachers";
         if($role == "najiltan") $role = "najiltans";
         _selectRow(
            "select id from $role where email=?",
            's',
            [$email],
            $id
        );
        
        if (isset($id)) {
            _exec("UPDATE $role SET pass = ? WHERE id = ?", "si", [$newpass, $id], $count);
            
            $headers = "From: recovery@teachervisit.mn";
            $ss = mail($user_email, 'Гэр айлчлал-Нууц үг сэргээх үйлдэл', 'teachervisit.mn сайтад нэвтрэх нууц үг сэргээх үйлдэл хийгдэж байна.', $headers);
        
            $to = $email;
            $from = 'recovery@teachervisit.mn';
            $fromName = 'teachervisit.mn';
        
            $subject = "teachervisit.mnn-Нууц үг сэргээлээ.";
        
            $htmlContent = " 
                        <html> 
                        <head> 
                            <title>Сайн байна уу?</title> 
                        </head> 
                        <body> 
                            <h1>Нууц үг сэргээлээ!</h1>
                            <p>Таны нууц үг: $newpass</p>
                            <br><p>Танд нэвтэрч орсны дараа нууц үгээ солихыг зөвлөж байна.</p>
                        </body> 
                        </html>";
        
            // Set content-type header for sending HTML email 
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
            // Additional headers 
            $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";
        
            // Send email 
            if (mail($to, $subject, $htmlContent, $headers)) {
            } else {
            }
            //echo "Таны мэйл хаягт код илгээлээ. Та 4 оронтой кодоо Нууц үг хэсэгт оруулаад Нэвтэрч орно уу. Нэвтэрч орсны дараа нууц үгээ солихыг зөвлөж байна. Баярлалаа";
            $_SESSION["recoveryerror"] = "Таны мэйл хаягт код илгээлээ. Та 4 оронтой кодоо нууц үг хэсэгт оруулаад нэвтэрч орно уу. Нэвтэрч орсны дараа нууц үгээ солихыг зөвлөж байна. (Email хаягынхаа Spam folder болон бусад хавтаснуудаа шалгаарай)";
            if($role == "users") $role = "admin";
            if($role == "teachers") $role = "teacher";
            if($role == "najiltans") $role = "najiltan";
            redirect("/recovery?role=$role");
        } else {
            if($role == "users") $role = "admin";
            if($role == "teachers") $role = "teacher";
            if($role == "najiltans") $role = "najiltan";
            $_SESSION["recoveryerror"] = "Таны оруулсан \"$email\" хаяг бүртгэлээс олдсонгүй!";
            redirect("/recovery?role=$role");
        }
    }
    else {
      redirect("/");
    }
}
?>