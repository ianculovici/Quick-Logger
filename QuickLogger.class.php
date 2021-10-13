<?php
/**
 * Quick Logger class for PHP with text formatting
 * 
 * Examples:
 *  - Declaration: 
 *        $log = new QuickLogger('/opt/log/application.log', 'INFO');
 *  - Usage:
 *        $log->info('Connection details: Host: %s, User: %s. Port: %d', $host, $user, $port);
 *        $log->error('Fatal error! Exiting...');
 *
 * @author ianculovici
 */
class QuickLogger {
    private $LEVEL = "";
    private $logLevels = ["OFF", "FATAL", "ERROR", "WARN", "INFO", "DEBUG", "TRACE", "ALL"];
    private $output = "";
    private $includeDate = true;

    function __construct($logfile="", $level = "WARN", $includeDate = true){
        $this->LEVEL    = $level;
        $this->include_date = $includeDate;
        if($logfile !== ""){
            $this->output = fopen($logfile, 'a+');
        }
    }

    private function prependObj($e, ...$o){
        $newO = [$e];
        foreach($o as $v){
            $newO[] = $v;
        }
        return $newO;
    }

    private function outputText($s, ...$o){
        if($this->output == ""){
            $s = str_replace('%n', "<br>\n", $s);
            echo sprintf($s, ...$o);
        } else {
            $s = str_replace('%n', "\n", $s);
            fprintf($this->output, $s, ...$o);
        }
    }

    private function outputError($s, ...$o){
        if($this->output === ""){
            $s = str_replace('%n', "<br>\n", $s);
            fprintf(STDERR, $s, ...$o);
        } else {
            $this->outputText($s, ...$o);
        }
    }

    public function log($messageLevel, $s,  ...$o){
        $o = $this->prependObj($messageLevel, ...$o);
        $s = '%s:' . $s . '%n';
        if($this->includeDate === true){
            $dateTime = new DateTime();
            $cDate =  $dateTime->format("Y-m-d h:i:s.u");
            $dateText = $cDate . " ";
            $s = '%s' . $s;
            $o = $this->prependObj($dateText, ...$o);
        }

        if(array_search(strtoupper($this->LEVEL), $this->logLevels) >= array_search(strtoupper($messageLevel), $this->logLevels)){
            if(array_search(strtoupper($messageLevel), $this->logLevels) <= array_search("ERROR", $this->logLevels)) {
                $this->outputError($s, ...$o);
            } else {
                $this->outputText($s, ...$o);
            }
        }
    }

    public function debug($s, ...$o){
        $this->log("DEBUG", $s, ...$o);
    }
 
    public function info($s, ...$o){
        $this->log("INFO", $s, ...$o);
    }
 
    public function warn($s, ...$o){
        $this->log("WARN", $s, ...$o);
    }
 
    public function error($s, ...$o){
        $this->log("ERROR", $s, ...$o);
    }
}
