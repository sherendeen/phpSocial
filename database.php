<?php
    // @license MIT (see license file)
    $status = '';
    
    
    
    /** connect to database */
    function dbConnect($dsn, $dbUsername, $dbPassword) : PDO {

        global $status;
        
        try {
            $db = new PDO($dsn, $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $status = 'You are now connected to the database.';
        } catch ( PDOException $e ) {
            echo '###exception caught!! ' . $e->getMessage();
        }
        
        return $db;
    }
    
    /**
     * retrieves the user IP address
     */
    function getIpAddress() {
        $ip = '';
        //$_SERVER['REMOTE_ADDR']
//         if(isset($_SERVER['HTTPS_CLIENT_IP'])){
//             //ip from share internet
//             $ip = $_SERVER['HTTPS_CLIENT_IP'];
//         } else if (!empty($_SERVER['HTTPS_X_FORWARDED_FOR'])) {
//             //ip pass from proxy
//             $ip = $_SERVER['HTTPS_X_FORWARDED_FOR'];
//         } else {
//             $ip = $_SERVER['REMOTE_ADDR'];
//         }
        
        $ip = $_SERVER['REMOTE_ADDR'];
        
        return $ip;
    }
    
    function getPostsFromTable(PDO $dbConn) : array {
        
        $query = 'SELECT postID, textContent, ipAddress, fileName, authorName, postDate, altText FROM postsTable ORDER BY postID DESC LIMIT 10;';
        $statement = $dbConn->prepare($query);
        $statement->execute();
        
        $elements = $statement->fetchAll();
        $statement->closeCursor();
        
        $last = count($elements) - 1;
        
        $posts = array();
        foreach ($elements as $i => $row) {
            $isFirst = ($i == 0);
            $isLast = ($i == $last);
            
            $post = new Post( $row['postID'] , $row['textContent'], $row['ipAddress'], 
                $row['fileName'].'', $row['authorName'], $row['postDate'], $row['altText']);
            array_push($posts, $post);
        }
        
        return $posts;
    }
    
    /**
     * inserts a new post into the database
     * @param PDO $dbConn database PDO connection
     * @param Post $post post instance
     */
    function dbInsert(PDO $dbConn, Post $post) : void {
        global $debug, $status;
        
        $queryString = 'INSERT INTO postsTable (postID, textContent, ipAddress, fileName, authorName, postDate, altText) 
VALUES (:postID, :textContent,:ipAddress, :fileName,:authorName,:postDate, :altText)';
        
        try {
            
            //setup INSERT query
            $statement = $dbConn->prepare($queryString);
            $statement->bindValue(':postID', NULL);
            $statement->bindValue(':textContent', $post->getTextContent());
            $statement->bindValue(':ipAddress', $post->getIpAddress());
            $statement->bindValue(':fileName', $post->getFileName());
            $statement->bindValue(':authorName', $post->getAuthor());
            $statement->bindValue(':postDate', $post->getPostDate());
            $statement->bindValue(':altText', $post->getAltText());
            //execute the query to mysql
            $statement->execute();
            
            $statement->closeCursor();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        if ($debug) {
            $status .= ' Inserted records.';
        }
        // do not return anything (void)
    }
    
    
?>
