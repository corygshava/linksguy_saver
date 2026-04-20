<?php
    if(!class_exists('fileops')){
        if(class_exists('maloader')){
            maloader::load_package('fileops');
        } else {
            die('Cant run without my loader, please load via the loader function');
        }
    }

    class meklog{
        public static $logpath = __DIR__."/../../../storage/appgen_history/";

        public static function setPath($path) {
            self::$logpath = $path;
            return true;
        }

        public static function mek($what,&$error = null){
            $daytamp = date("dmy");
            $tstamp = date("d_m_y-h:i:s");
            $logfile = self::$logpath."[{$daytamp}]_eventslog.log";
            $logline = $what ?? "blank log request";

            // require_once __DIR__.'/../../_packages/loadpackages.php';

            $fylops = new fileops();

            $createres = $fylops::create_file_if_missing($logfile);

            if($createres){
                file_put_contents($logfile, "\n[$tstamp] - $logline", FILE_APPEND | LOCK_EX);
                say("line: $logline","addlog");
            } else {
                throw new Exception("error creating logfile. retry request", 1);
            }
        }

        public static function new($what,&$error = null) {
            return self::mek($what,$error);
        }
    }
?>