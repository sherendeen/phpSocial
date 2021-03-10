<!DOCTYPE html>
<?php
    /**
    * @author Seth G. R. Herendeen
    * @license MIT (see license file)
    */
    
    include_once('./database.php');
    include_once('./post.php');
    
    ini_set('display_startup_errors',1);
    ini_set('display_errors',1);
    error_reporting(-1);
    
    // Refacted; Fill in your database information accordingly
    $dsn = "mysql:host=localhost;dbname=";
    $dbUsername = '';
    $dbPassword = '';
    // 
    
    $conn = dbConnect($dsn, $dbUsername, $dbPassword);
    
    $debug = FALSE;
    
    $PHP_SELF = 'index.php';
    
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style_n12.css">
        <title>Social Site</title>
    </head>
    <body>
    	<header>
    		<h1>Create new post</h1>
    		
    		<!-- Post with optional file upload -->
    		<form id="myForm" name="myForm" action="<?php echo($PHP_SELF); ?>" method="post"  enctype="multipart/form-data" >
				
				<div>
					<label for="name">Name</label>
					<input type="text" name="name" id="name" value="Anonymous" />
            	</div>
            	
            	<div>
            		<label for="textContent" class="labelForInput">Message</label>
            		<textarea id="textContent" name="textContent" rows="5" cols="30"></textarea>
            	</div>
            	
            	<div>
            		<div>
            			<label for="fileToUpload">Upload image (>1MB)</label>
            			<input type="file" name="fileToUpload" id="fileToUpload" />
            		</div>
            		<div>
            			<label for="altText">Image description</label>
            			<input type="text" name="altText" id="altText" placeholder="describe image!"/ >
            		
			</div>
            	</div>
            	
            	<button type="submit" name="submit" id="submit">Post</button>
            	<?php
            	
				// check to see if the form was submitted
            	if (isset($_POST['submit']) && !empty($_POST['textContent']) && !empty($_POST['name'])) {
				    $textContent = htmlspecialchars($_POST['textContent']);
				    $author = htmlspecialchars($_POST['name']);
				    
				    if($debug) {
				        echo ('<div class="debug">');
				        echo ('<p>content:'.$textContent.'</p>');
				        echo ('<p>author:'.$author.'</p>');
				    }
				    
				    // determine if there is an image to be uploaded
				    if (isset($_FILES['fileToUpload']['name']) 
				        && $_FILES['fileToUpload']['size'] > 0 
				        && $_FILES["fileToUpload"]["size"] < ( 2 * 1024 * 1024 ) 
				        && !empty($_POST['altText'])) {
				        
				        $tmp_name = $_FILES['fileToUpload']['tmp_name'];
				        $path = 'uploads' ;//. DIRECTORY_SEPARATOR;
				        $name = $path . DIRECTORY_SEPARATOR . $_FILES['fileToUpload']['name'];
				        
				        $altText = htmlspecialchars($_POST['altText']);
				        
				        $error = $_FILES['fileToUpload']['error'];
				        
				        $result = move_uploaded_file($tmp_name, $name);
				        
				        if($debug) {
				            echo ('<p>path:'.$path.'</p>');
				            echo ('<p>tmp_name:'.$tmp_name.'</p>');
				            echo ('<p>name:'.$name.'</p>');
				        }
				        
				        if ($debug && $result){
				            echo('<p>Successfully moved uploaded file</p>');
				        } else if ($debug) {
				            echo ('<p>upload error:'.$error.'</p>');
				        }
				        
				        $post = new post(-1, $textContent, getIpAddress(), $name, $author, date("Y-m-d H:i:s"), $altText);
				        dbInsert($conn, $post);
				    } else {
				        $post = new post(-1, $textContent, getIpAddress(), '', $author, date("Y-m-d H:i:s"));
				        dbInsert($conn, $post);
				    }
				    
				    if ($debug) {
				        echo ('</div>');
				    }
				    
				}
				
				?>
            </form>
    	</header>
    	<main>
            <?php 
            $elements = NULL;
        
            $elements = getPostsFromTable($conn);
        
            foreach ($elements as $element)  {
                echo $element->getPostDisplay();
            }
        
            $conn = null;
            ?>
        </main>
        <footer>
        	<h2>&copy; 2020, 2021 Seth Herendeen</h2>
        	<p>
			<a href="rules.html">terms</a> 
			<a href="privacy.html">privacy policy</a>
			<a href="https://github.com/sherendeen/phpSocial">code</a>
		</p>
        </footer>
    </body>
</html>
