    <?php

Library::import('recess.framework.controllers.Controller');
include('apps/utils/utils.php');
include('http.php');

/**
 * !RespondsWith Layouts
 * !Prefix Views: home/, Routes: /converter
 */
class ConverterHomeController extends Controller {

    /** !Route GET */
    function index() {

        $this->flash = 'Welcome to your new Recess application!';
    }

    /** !Route GET, /converter/$text */
    function ttsGET($text) {
        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/tts/speeches/';
        $filename = $this->getSpeech($text, $savePath);
        
        $filePath = $savePath . $filename;
        
        if (file_exists($filePath)) {
            
            header("Content-Type: audio/mpeg");
            header('Content-Length: ' . filesize($filePath));
            header('Content-Disposition: inline; filename="'. $filename. '"');
            header('X-Pad: avoid browser bug');
            header('Cache-Control: no-cache');
            ob_clean();
            flush(); 
            readfile($filePath);
            unlink($filePath);
            unlink(str_replace('mp3', 'log', $filePath));
            exit;
            
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
            echo "no file";
        }
        
    }
    
    /** !Route POST, /converter/ */
    function ttsPOST() {
        $text = $_POST["text"];
        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/tts/speeches/';
        $filename = $this->getSpeech($text, $savePath);
        
        $filePath = $savePath . $filename;
        
        if (file_exists($filePath)) {
            header("Content-Type: audio/mpeg");
            header('Content-Length: ' . filesize($filePath));
            header('Content-Disposition: inline; filename="'. $filename. '"');
            header('X-Pad: avoid browser bug');
            header('Cache-Control: no-cache');
            header('charset=ISO-8859-1');
            readfile($filePath);
            unlink($filePath);
            unlink(str_replace('mp3', 'log', $filePath));
            exit;
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
            echo "no file";
        }
        
    }
    
    /** !Route PUT, /converter/ */
    function ttsPUT(){
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed', true, 405);
    }
    
    /** !Route DELETE, /converter/ */
    function ttsDELETE(){
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed', true, 405);
    }
    
    
    
    /**
     *
     * @param type $text text to be converted to speech
     * @param type $savePath path where the file is to be saved
     * @return type string representing file name
     */

    function getSpeech($text, $savePath) {
        
        
        
        $ranStr = utils::randomString(10);

        $newFileName = $savePath . $ranStr . '.mp3';
        
        if (file_exists($newFileName)) {

            $i = 0;

            $newFileName = $savePath . $ranStr . $i . '.mp3';

            while (file_exists($newFileName)) {
                $i++;
                $newFileName = $savePath . $ranStr . $i . '.mp3';
            }
        }

        $command = 'sh ' . $_SERVER['DOCUMENT_ROOT'] . '/tts/scripts/tts.sh  ' . '"' .$text . '"' . ' ' . $savePath . ' ' . $ranStr;
        
        $output = shell_exec($command);
        
        return $ranStr . '.mp3';
    }

}

?>