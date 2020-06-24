<?php
session_start();
include("./classes/caller.php");
$appcall = new Caller($config);
?>
<div class="table-responsive col-sm-12">
    <table id="subjtable" class="table">
        <thead>
            <tr class="sunflower-light">
                <th>Subject Code</th>
                <th>Section</th>
                <th>Description</th>
                <th>Credit</th>
                <th>Days</th>
                <th>Time</th>
                <th>Room</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $req1 = array(
                'class' => 'webesms',
                'action' => 'get_semstudent_subjects',
                'token' => $_SESSION['token'],
                'timestamp' => get_timestamp(),
                'sy' => $_GET['sy'],
                'sem' => $_GET['sem'],
                'studid' => $_GET['studid'],
                'user' => $_SESSION['appman']
            );
            $get_studsubj = $appcall->apiCall($req1);
            $studsubj = json_decode($get_studsubj);
            $subjects = $studsubj->data;
            $num = 1;
            foreach ($subjects as $key => $value) {
                echo "<tr id='row_".$num."'>";
                foreach ($value as $k => $v) {
                    if(($k == 'sy') || ($k == 'sem') || ($k == 'studid')){
                        
                    }  else {
                        echo "<td id='".$k."'>" . $v . "</td>";
                    }
                }
                echo '<td><div class="btn-group-vertical"><button type="button" class="btn btn-danger" onclick="delClick(\'row_'.$num.'\');">&times;</button></div></td>';
                echo "</tr><br/>";
                $num++;
            }
            ?>
        </tbody>
    </table>
</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


