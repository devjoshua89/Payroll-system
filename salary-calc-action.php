<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Calculation</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
        if($_SESSION["mgrid"] === ""){
          echo $_SESSION['mgrid'];
          echo "login";
          header("Location: index.php ");
        }
      ?>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 theme-bg border-bottom shadow-md">
        <a class="navbar-brand brand-light my-0 mr-md-auto" href="#">
            Payroll
        </a>
      </div>

      <div class="container h-100">
        <div class="row align-items-center h-100" >
            
            
          <div class="col-8 mx-auto">

                <div class="shadow-lg bg-white mt-4 rounded">
                    <div class="col text-center p-3">
                    <?php
                        $conn = new mysqli('localhost','root','');
                        if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        }  
                        mysqli_select_db($conn,"salary");
                        $mon=$_POST['month'];
                        $leav=$_POST['leave'];
                        $x=$_POST['empid'];
                        $sql = "SELECT * FROM employee WHERE employee_id='$x'";
                        $result = $conn->query($sql);
                        if ($result->num_rows <= 0) {       
                        $message="No Employee Found with Employee ID: ".$x;
                        echo"<p>$message</p><form action='salary-calc.php'><button type='submit' class='btn theme-btn'>Try Again</button></form>";
                        }else{
                            $sql2 = "SELECT * FROM calcul WHERE employee_id='$x' AND month='$mon' ";
                        $result2 = $conn->query($sql2);
                        if ($result2->num_rows > 0) {       
                        $message="Salary Already Calculated for ".$mon." With Employee ID: ".$x;
                        echo"<p>$message</p><form action='salary-calc.php'><button type='submit' class='btn theme-btn'>Done</button></form>";
                        }
                        else{
                        while($row = $result->fetch_assoc()){
                            $em=$row['employee-id'];
                            $d=$row['designation'];
                        }
                        $sal=0;
                        $deduct=0;
                        $msal;
                        if($d=="Founder"){
                            $msal=200000;
                            if($leav==1){
                            $deduct=$msal*0.25;
                        }
                            $sal=($msal)-($deduct);
                        }

                        if($d=="Co-Founder"){
                            $msal=150000;
                            if($leav==2){
                                $deduct=$msal*0.20;
                        }
                            $sal=($msal)-($deduct);
                        }

                        if($d=="Chief Advisor"){
                            $msal=100000;
                            if($leav==3){
                                $deduct=$msal*0.18;
                            }
                            $sal=($msal)-($deduct);
                        }

                        if($d=="Secretory"){
                            $msal=70000;
                            if($leav>3){
                                $deduct=$msal*0.15;
                            }
                            $sal=($msal)-($deduct);
                        }

                        if($d=="CMO"){
                            $msal=65000;
                            if($leav>3){
                                $deduct=$msal*0.15;}
                            $sal=($msal)-($deduct);
                        }

                        if($d=="Chief of Staff"){
                            $msal=50000;
                            if($leav>3){
                                $deduct=$msal*0.15;}
                            $sal=($msal)-($deduct);
                        }
                        
                        if($d=="HR"){
                            $msal=45000;
                            if($leav>3){
                                $deduct=$msal*0.15;}
                            $sal=($msal)-($deduct);
                        }
                        $sal=round($sal,2);
                        $deduct=round($deduct,2);
                        $sql="INSERT INTO calcul (employee_id,design,month,bsal,deduct,tsal,leav) VALUES ('$x','$d','$mon','$msal','$deduct','$sal','$leav')";
                        if ($conn->query($sql) === TRUE) {
                    
                            print "<table class='table'><tr> <td>Employee ID</td><td>";    
                            echo $x; 
                            print "</td></tr>";
                            print "<tr> <td>Designation</td><td>";    
                            echo $d; 
                            print "</td></tr>";    
                            print "<tr> <td>Month</td><td>";    
                            echo $mon; 
                            print "</td></tr>";
                            print "<tr> <td>Salary</td><td>";    
                            echo $msal; 
                            print "</td></tr>";
                            print "<tr> <td>Dedecuted </td><td>";    
                            echo $deduct; 
                            print "</td></tr>";
                            print "<tr> <td>Final Salary</td><td>";    
                            echo $sal; 
                            print "</td></tr>";
                            print "<tr> <td>Tax Slab</td><td>";    
                            echo $leav; 
                            print "</td></tr></table>";

                            echo"<form action='dashboard.php'><button type='submit' class='btn theme-btn'>Done</button></form>";

                        }
                        else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                        mysqli_close($conn);

                        }
                        }
                        




                    ?>
                    </div>
                    

                </div>
                
          </div>
        </div>
          
      </div>
</body>
</html>