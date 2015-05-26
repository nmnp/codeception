<?php
namespace Library;

/**
 * Class to read/parse config file
 *
 * @createdOn: April 16, 2015
 * @author: Naresh Maharjan <nareshmaharjan@lftechnology.com>
 * @package: CodeceptionDemo
 * @subpackage: library
 */

class ParseConfig
{
    /**
     * @var array|null $config configuration object
     */
    private $config = null;

    /**
     * @var string|null $section configuration section
     */
    private $section = null;

    /**
     * @var string $path config path string
     */
    private $path = null;
    /**
     * constructor function
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->path = ROOT.'config/application.ini';
        if(empty($this->config)){
            $this->config = $this->getConfig();
        }
    }

    /**
     * get configurations from application.ini file
     *
     * @return array
     * @throws \Exception
     */
    private function getConfig()
    {
        if(!file_exists($this->path)){
            throw new \Exception("Application.ini file not found in location ".ROOT."config/");
        }
        $config = parse_ini_file($this->path,true);
        $configArray = $this->getConfigFromFile($config);
        $parsedConfig = $this->getConfigForEnv($configArray);
        return $parsedConfig;
    }

    /**
     * get config based upon the application environment
     *
     * @param array $configArray
     * @return array
     * @throws SectionNotFoundException
     */
    private function getConfigForEnv(array $configArray)
    {
        if(!array_key_exists(APPLICATION_ENV, $configArray)){
            throw new SectionNotFoundException("No section was found in config file for ".APPLICATION_ENV);
        }
        if(APPLICATION_ENV === 'production'){
            $config = $configArray['production'];
        }else{
            $config = array_replace_recursive($configArray['production'],$configArray[APPLICATION_ENV]);
        }
        return $config;
    }
    /**
     * get configuration of a section
     *
     * @param string|null $section
     * @return mixed
     * @throws \Exception
     */
    public function getConfigSection($section = null)
    {
        if(empty($section) && empty($this->section)){
            throw new InvalidSectionException("Invalid section");
        }

        if(!array_key_exists($section, $this->config) && !array_key_exists($this->section, $this->config)){
            throw new SectionNotFoundException("No section was found in config file with name ".$section);
        }
        return !empty($section) ? $this->config[$section] : $this->config[$this->section];
    }

    /**
     * get configuration of section by key
     *
     * @param string $key
     * @param string|null $section
     * @return mixed
     * @throws \Exception
     */
    public function getSingleConfig($key, $section = null)
    {
        if(empty($key)){
            throw new \Exception("Invalid key");
        }

        $config = $this->getConfigSection($section);

        if(!array_key_exists($key, $config)){
            throw new \Exception("Key $key was not found.");
        }
        return $config[$key];

    }

    /**
     * set section of configuration
     *
     * @param string $section
     * @throws \Exception
     */
    public function setSection($section)
    {
        if(empty($section)){
            throw new \Exception("Invalid section");
        }
        $this->section = $section;
        return $this;
    }

    /**
     * generate multidimensional array of configurations
     *
     * @param $array
     * @return array
     */
    private function getConfigFromFile($array)
    {
        $returnArray = array();
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = $this->getConfigFromFile($value);
                }
                $x = explode('.', $key);
                if (!empty($x[1])) {
                    $x = array_reverse($x, true);
                    if (isset($returnArray[$key])) {
                        unset($returnArray[$key]);
                    }
                    if (!isset($returnArray[$x[0]])) {
                        $returnArray[$x[0]] = array();
                    }
                    $first = true;
                    foreach ($x as $k => $v) {
                        if ($first === true) {
                            $b = $array[$key];
                            $first = false;
                        }
                        $b = array($v => $b);
                    }
                    $returnArray[$x[0]] = array_merge_recursive($returnArray[$x[0]], $b[$x[0]]);
                } else {
                    $returnArray[$key] = $array[$key];
                }
            }
        }
        return $returnArray;
    }
} 