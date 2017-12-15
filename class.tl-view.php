<?php
if(!class_exists('TlView'))
{
    class TlView
    {
        private $path = '', $file = '', $filename = '';
        private $vars = array();

        public function __construct()
        {
            // nothing to do
        }

        protected function setViewPath($path)
        {
            $this->path = $path;
        }

        protected function setViewFilename($filename)
        {
            $this->filename = $filename;
        }

        protected function setViewGlobalVars($vars)
        {
            $this->vars = $vars;
        }

        protected function view($filename = '', $vars = array(), $return = false)
        {
            if(empty($filename))
                $filename = $this->filename;

            $this->file = $this->path.str_replace('.php', '', $filename).'.php';
            if(!file_exists($this->file))
                $this->file = rtrim(realpath(dirname(__FILE__)), '/').'/'.$this->file;

            if(!file_exists($this->file))
            {
                $msg = '<pre>could not find template file <em>'.$this->file.'</em></pre>';
                if(!$return)
                    echo $msg;
                return $msg;
            }

            ob_start();

            if(count($this->vars))
                $vars = array_merge($this->vars, $vars);
            if(count($vars))
                extract($vars);

            include($this->file);

            $output = ob_get_contents();
            ob_end_clean();

            if(!$return)
                echo $output;

            return $output;
        }
    }
}
?>