<?php   
/**
* @author Seth G. R. Herendeen
* @license MIT
*/
class post {
    
    private $postNo;
    private $author = '';
    private $textContent;
    private $postDate;
    private $fileName;
    private $ipAddress;
    private $altText;
    
    /**
     * 
     * @param int $postNo
     * @param string $textContent
     * @param string $ipAddress
     * @param string $fileName
     * @param string $author
     * @param $postDate
     */
    public function __construct(int $postNo = -1, string $textContent, string $ipAddress, 
        string $fileName = '', string $author = 'Anonymous', $postDate, string $altText = '') {
        
        $this->postNo = $postNo;
        $this->textContent = $textContent;
        $this->author = $author;
        $this->fileName = $fileName;
        $this->postDate = $postDate;
        $this->ipAddress = $ipAddress;
        $this->altText = $altText;
    }
    
    /**
     * @param string $fileName the name of the file
     */
    public function setFileName(string $fileName) {
        $this->fileName = $fileName;
    }
    
    public function getPostNo() : int {
        return $this->postNo;
    }
    
    /**
     * @return mixed
     */
    public function getPostDate() {
        return $this->postDate;
    }
    
    /**
     * @return string the file name. e.g: "62831.jpg"
     */
    public function getFileName() : string {
        return $this->fileName . '';
    }
    
    /**
     * @return $ipAddress of the poster
     */
    public function getIpAddress() {
        return $this->ipAddress;
    }
    
    public function getTextContent() : string {
        return $this->textContent;
    }
    
    public function getAuthor() : string {
        return $this->author;
    }
    
    public function getAltText() : string {
        return $this->altText;
    }
    
    public function setAltText(string $altText): void {
        $this->altText = $altText;
    }
    
    /**
     * 
     * @param string $textContent
     */
    public function setTextContent(string $textContent) {
        $this->textContent = $textContent;
    }
    
    public function getPostDisplay() : string {
        
        if (empty($this->fileName)) {
            return "
            <article class='post'>
                    <p>
                    <label>$this->author</label>
                    PostNo: $this->postNo - $this->postDate
                    </p>
                    <hr />
                    <p>$this->textContent</p>
            </article>
            ";
        } else {
            return "
            <article class='post'>
                    <p>
                    <label>$this->author</label>
                    PostNo: $this->postNo - $this->postDate
                    </p>
                    <hr />
                    
                    <img src='$this->fileName' class='thumbnail' alt='$this->altText' loading='lazy' />
                    <p>$this->textContent</p>
            </article>
            ";
        }
    }
    
    
} ?>
