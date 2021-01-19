<?php
global $MESS;
IncludeModuleLangFile(__FILE__);

class multisearch_api extends CModule
{
	var $MODULE_ID = 'multisearch.api';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    protected $errors;
	
	function multisearch_api()
	{
		$arModuleVersion = array();
		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");
		
		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}
		else
		{
			$this->MODULE_VERSION = "1.0.0";
			$this->MODULE_VERSION_DATE = "2020-08-14 12:00:00";
		}

		$this->MODULE_NAME = "Multisearch API";
		$this->MODULE_DESCRIPTION = "Модуль для взаимодействия с api Multisearch";
	}
	
	function DoInstall()
	{
		$this->InstallFiles();
        $this->InstallDB();
        RegisterModule($this->MODULE_ID);
	}
	
	function DoUninstall()
	{
		$this->UnInstallFiles();
        $this->UnInstallDB();
        UnRegisterModule($this->MODULE_ID);
	}
    
	function InstallFiles()
	{
		return true;
	}
    
	function UnInstallFiles()
	{
		return true;
	}

    function InstallDB($arParams = array())
    {
        return true;
    }

    function UnInstallDB($arParams = array())
    {
        return true;
    }
}