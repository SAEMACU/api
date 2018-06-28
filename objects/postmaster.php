<?php 


ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../config/database.php';
include_once '../objects/postmaster.php';

session_start();
$database = new Database();
$db = $database->getConnection();
$ob = new Postmaster($db);

if(isset($_POST['savepost']))
{
	$ob->create($_POST, $_FILES);
}
else if(isset($_POST['p_id']))
{
	$ob->update_post_status($_POST);
}
else if(isset($_POST['validate']))
{
	$ob->validate($_POST);
}

class Postmaster{
 
    /*Properties*/
    private $conn;
    private $table_name = "post_master";
	
    public $id;
    public $user_id;
    public $post_image;
    public $created_at;
    public $post_text;
    public $user_email;
	public $like_diislike;
	public $l_c_user_id;
	
    /*Constructor for db connection*/
    public function __construct($db){
        $this->conn = $db;
    }
	
	/*read posts*/
	function read(){
 
		/*select query to select all posts and comments*/
		$query = "SELECT DISTINCT p.post_image, p.user_id, p.id, p.post_text, u.user_email, ulc.like_diislike FROM " . $this->table_name . " p LEFT JOIN user_master u ON p.user_id = u.id LEFT JOIN users_likes_comments ulc ON ulc.post_id = p.id ORDER BY p.created_at DESC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	
	function create($post, $file)
	{
		$name = $_FILES["post_image"]["name"];
		$ext = end((explode(".", $name)));
		$post_text = $post['post_text'];
		$post_image = 'a_'.rand().'.'.$ext;//$file["post_image"]["name"];
		$user_id = $_SESSION['id'];
		
		
		/*upate query*/
		$query = "INSERT INTO " . $this->table_name . " (user_id, post_text, post_image) VALUES ($user_id, '$post_text', '$post_image')";
		$stmt = $this->conn->prepare($query);
		if($stmt->execute()){
		}
		else{
			echo 'Could not update!';
		}
		
		$target_dir = "img/"; 
		$target_file = $target_dir . basename($post_image);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		/*checking for fake images*/
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["post_image"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		/*checking if file aleady exists*/
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		/*checking file size*/
		if ($_FILES["post_image"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		/*checking file formats*/
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		/*final checking for errors if any else upload file*/
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		} else {

			if (move_uploaded_file($_FILES["post_image"]["tmp_name"], 'img/'.$post_image)) {
				echo "The file ". basename( $_FILES["post_image"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		/*redirect to header page*/		
		header('Location: http://www.organicway.co.in/api/api/test/index.php');
		
	}
	
	function update_post_status($post)
	{
	    	$session_id = $_SESSION['id'];
	    	$post_id = $post['p_id'];
		//now insert in the common table_name
		$l_c_user_id = $session_id;
		$like_diislike = 1;// for like 1 for dislike then either use incremental value and check even or odd to determine liked or diliked
		$query = "INSERT INTO users_likes_comments (l_c_user_id, post_id, like_diislike) VALUES ($l_c_user_id, $post_id, $like_diislike)";
	
			$stmt = $this->conn->prepare($query);
		 
			$msg[0] = 0;
			if($stmt->execute()){
				$msg[0] = 1;
				
			}
			
			echo json_encode($msg);
	}
	
	function validate($post)
	{
		$email_id = $post['email_id'];
		$password = $post['pwd'];
		$query = "SELECT id FROM user_master WHERE user_email = '$email_id' and user_password = '$password'";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		
		$read = $stmt;
		$num = $read->rowCount();

		/*checking if more than 0 records found*/
		if($num>0){
		 
			while ($row = $read->fetch(PDO::FETCH_ASSOC)){
				if($row['id']){
					$_SESSION['id'] = $row['id'];
					/*redirect to header page*/						
					header('Location: http://www.organicway.co.in/api/api/test/index.php');
				}
				else
				{
					header('Location: http://www.organicway.co.in/api/api/test/login.php');
				}
			}
		}
	
		
	}

}
