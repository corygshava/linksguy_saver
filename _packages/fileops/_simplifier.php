<?php

    class simplifier extends fileops{
		public static function c_file(string $path, string &$error = null): bool {
			return self::create_file_if_missing($path,$error);
		}

        public static function saferead($path,$wait = false,$tries = 5,&$error = null){
            return self::safe_read_file($path, $wait,$tries,$error);
        }
        public static function safe_read($data,&$error = null){
            $path = $data['path'] ?? 'path';
            $wait = $data['wait'] ?? false;
            $tries = $data['tries'] ?? 5;

            return self::safe_read_file($path, $wait,$tries,$error);
        }

        public static function safewrite_txt($path,$data,$wait = false,$tries = 5,&$error = null){
            return self::safe_write_text($path,$data, $wait,$tries,$error);
        }
    }

    class fl_ extends simplifier{}