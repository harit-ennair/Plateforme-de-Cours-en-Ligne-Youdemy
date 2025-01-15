<?php
namespace Youcode\youdemy;

include $_SERVER['DOCUMENT_ROOT'].'/Youdemy/vendor/autoload.php';
use Youcode\youdemy\database;
use Youcode\youdemy\user;


class admin extends user{

    
    

    public function affichage()
    {

        $sql = "SELECT * FROM users WHERE role != 'admin' ORDER BY status"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach ($users as $user) {
            echo '<tr class="row-user">';
            echo '<td class="column-name">' . $user['username'] . '</td>';
            echo '<td class="column-email">' . $user['email'] . '</td>';
            echo '<td class="column-email">' . $user['role'] . '</td>';
            echo '<td class="column-email">' . $user['status'] . '</td>';
            if ($user['status'] == 'active') {
                echo '<td class="column-status active">
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=suspended" class="act" >Disactive</a>
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=panding" class="act">panding</a>
    
                </td>'; 
            } else if ($user['status'] == 'suspended') {
                echo '<td>
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=active" class="act">Active</a>
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=panding" class="act">panding</a>
                </td>';
            }else  {
                echo '<td>
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=suspended" class="act" >Disactive</a>
                    <a href="../pages/adminpage.php?user_id=' . $user['user_id'] . '&activety=active" class="act">Active</a>
                </td>';
            }
            echo '</tr>';
        }
    }
    public function updateactivety($user_id, $activety)
    {
        $userId = $user_id;
        $newactivety = $activety;
        
        $sql = "UPDATE users SET status = :status WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':status' => $newactivety,
            ':user_id' => $userId
        ]);
    

    
    }
    
    
    
    }
    
    
    