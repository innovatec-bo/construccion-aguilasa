<?php

namespace com\arenybakk;

/**
 * A class loader that loads from a series of locations.
 * 
 * Supports namespaces given that loadable classes are placed in a folder
 * structure matching the namespace path.
 * 
 * Calling the register method enables automatic loading when a class is
 * referenced in code.
 * 
 * @author Are Nybakk <are[at]arenybakk.com>
 * @copyright Copyright 2011, Are Nybakk
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */
class ClassLoader {



  /**
   * @var     Array     Locations for where to look for classes.
   */
  public $locations;
  
  
  
  /**
   * Constructor.
   * 
   * @param   Array     $locations      an optional array of possible class locations.
   */
  public function __construct($locations = Array('classes', 'libraries')) {
  
    $this->locations = $locations;
    
  }
  
  
  
  /**
   * Adds a location where classes may be loaded from.
   * 
   * @param   string    $locations      a location path.
   */
  public function addLocation($location) {
  
    $this->locations[] = $location;
    
  }
  
  
  
  /**
   * Registers the class loader so it may automatically load requested classes.
   */
  public function register() {
  
    spl_autoload_register(Array($this, 'load'));
    
  }
  
  
  
  /**
   * Unregisters the class loader.
   */
  public function unregister() {
  
    spl_autoload_unregister(Array($this, 'load'));
    
  }
  
  
  
  /**
   * Loads a class. If the class loader has been registered, this function is called automatically.
   * 
   * @param   string    $name     a class name. Can contain namespace.
   * @return  bool                true if class exists and was loaded successfully, false otherwise.
   */
  public function load($name) {
  
    return $this->exists($name, true);
    
  }
  
  
  
  /**
   * Check if a class can be loaded.
   * 
   * @param   string    $name     a class name. Can contain namespace.
   * @return  bool                true if class exists, false otherwise.
   */
  public function canLoad($name) {
  
    return $this->exists($name, false);
    
  }
  
  
  
  /**
   * Helper function which looks for a requested file.
   * 
   * @param   string    $name     a class name. Can contain namespace.
   * @param   bool      $load     whether to load class or not.
   * @return  bool                true if class exists (and was loaded successfully), false otherwise.
   */
  private function exists($name, $load) {
  
    //Convert namespace to directory
    $partialPath = str_replace('\\', '/', $name);
    $fullPath = '';
    
    $locations = $this->locations;
    foreach($locations as $location) {
    
      $fullPath = $location . '/' . $partialPath . '.php';
      
      if(file_exists($fullPath)) {
        if($load) {
            require($fullPath);
        }
        return true;
      }
      
    }
    
    return false;
    
  }
  
  
  
}

?>