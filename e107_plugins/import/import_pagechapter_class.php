<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2009 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *
 *
 * $Source: /cvs_backup/e107_0.8/e107_plugins/import/import_user_class.php,v $
 * $Revision: 11315 $
 * $Date: 2010-02-10 10:18:01 -0800 (Wed, 10 Feb 2010) $
 * $Author: secretr $
 */

/*
Class intended to simplify importing of user information from outside.
It ensures that each user record has appropriate defaults

To use:
	1. Create one instance of the class
	2. Call emptyUserDB() to delete existing users
	3. If necessary, call overrideDefault() as necessary to modify the defaults
	4. For each record:
		a) Call getDefaults() to get a record with all the defaults filled in
		b) Update the record from the source database
		c) Call saveUser($userRecord) to write the record to the DB
*/

class pagechapter_import
{
	var $pageDB = null;
	var $blockMainAdmin = true;
	var $error;

	var $defaults = array(
			'chapter_id'                => '',
			'chapter_parent'            => 1,
			'chapter_name'              => '',
			'chapter_sef'               => '',
			'chapter_meta_description'  => '',
			'chapter_meta_keywords'     => '',
			'chapter_manager'           => e_UC_ADMIN,
			'chapter_icon'              => '',
			'chapter_order'             => 0,
			'chapter_template'          => 'default',
			'chapter_visibility'        => 0,
			'chapter_fields'            => null

	);

	// Fields which must be set up by the caller.  
	var $mandatory = array(
		'chapter_name'
	);
  
	// Constructor
	function __construct()
	{
	    $this->pageDB = e107::getDb('pagechapter');	// Have our own database object to write to the table
	}


	// Empty the  DB
	function emptyTargetDB($inc_admin = FALSE)
	{
		$this->pageDB->truncate('page_chapters');

		$insert = array(
			'chapter_id'                => '1',
			'chapter_parent'            => '0',
			'chapter_name'              => 'General',
			'chapter_sef'               => 'general',
			'chapter_meta_description'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et tempor odio. Quisque volutpat lorem nec lectus congue suscipit. In hac habitasse platea dictumst. Etiam odio nisi, egestas vitae amet.',
			'chapter_meta_keywords'     => '',
			'chapter_manager'           => '0',
			'chapter_icon'              => '',
			'chapter_order'             => '0',
			'chapter_template'          => 'default',
			'chapter_visibility'        => '0',
			'chapter_fields'            => null
			);


		 $this->pageDB->insert('page_chapters',$insert); // insert a default book.
	}
  
  
	// Set a new default for a particular field
	function overrideDefault($key, $value)
	{
//    echo "Override: {$key} => {$value}<br />";
    	if (!isset($this->defaults[$key])) return FALSE;
		$this->defaults[$key] = $value;
	}

  
  // Returns an array with all relevant fields set to the current default
	function getDefaults()
	{
		return $this->defaults;
	}

	/**
	 * Insert data into e107 DB
	 * @param row - array of table data
	 * @return integer, boolean - error code on failure, TRUE on success
	 */
	function saveData($row)
	{

		if(empty($row['chapter_name']))
		{
			return 3;
		}


		if(!$result = $this->pageDB->insert('page_chapters',$row))
		{
	     	return 4;
		}
	
		//if ($result === FALSE) return 6;
	
		return true;
	}
 

 
	function getErrorText($errnum)    // these errors are presumptuous and misleading. especially '4' .
	{
		$errorTexts = array(
	    	0 => 'No error', 
	    	1 => 'Can\'t change main admin data', 
	    	2 => 'invalid field passed',
			3 => 'Mandatory field not set', 
			4 => 'Entry already exists', 
			5 => 'Invalid characters in user or login name',
			6 => 'Error saving extended user fields'
		);
			
		if (isset($errorTexts[$errnum])) return $errorTexts[$errnum];
		
		return 'Unknown: '.$errnum;
	
	}
  
  
  
}


?>