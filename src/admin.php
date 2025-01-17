<?php
namespace Youcode\youdemy;

include $_SERVER['DOCUMENT_ROOT'].'/Youdemy/vendor/autoload.php';
// use Youcode\youdemy\database;
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

    public function addcategories($name, $description) {

 
        $stmt = $this->pdo->prepare("INSERT INTO categories (name,description)VALUES(?,?)");
        $stmt->execute([$name, $description]);

    }
    public function affichagedescription()
    {
        $sql = "SELECT * FROM categories;"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll();
        return $users;
        // foreach ($users as $user) {
        //     echo '<tr class="row-user">';
        //     echo '<td class="column-name">' . $user['name'] . '</td>';
        //     echo '<td class="column-email">' . $user['description'] . '</td>';
        //     echo '<td class="column-email">' . $user['created_at'] . '</td>';
        //     echo '<td>
        //     <a href="../pages/admintag.php?id=' . $user['category_id'] . '"class="act" >delete</a>
        //     </td>';
        //     echo '</tr>';
        // }
    }
    

    public function deletedescription($category_id)
    {
        
        $sql = "DELETE FROM categories WHERE category_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $category_id);
        $stmt->execute();
    }
    
    public function addtags($name) {

 
        $stmt = $this->pdo->prepare("INSERT INTO tags (name)VALUES(?)");
        var_dump($stmt);
        $stmt->execute([$name]);

    }
    public function affichagetags()
    {
        $sql = "SELECT * FROM tags;"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll();
        return $users;
        // foreach ($users as $user) {
        //     echo '<tr class="row-user">';
        //     echo '<td class="column-name">' . $user['name'] . '</td>';
        //     echo '<td class="column-email">' . $user['created_at'] . '</td>';
        //     echo '<td>
        //     <a href="../pages/admintag.php?id=' . $user['tag_id'] . '"class="act" >delete</a>
        //     </td>';
        //     echo '</tr>';
        // }
    }

    public function deletetags($tag_id)
    {
        
        $sql = "DELETE FROM tags WHERE tag_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $tag_id);
        $stmt->execute();
    }
    
    
    }
    
    
    