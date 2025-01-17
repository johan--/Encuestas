<?php

//
// Shared code for PHPMaker and PHP Report Maker
//

/**
 * Functions for converting encoding
 */

function ew_ConvertToUtf8($str) {
	return ew_Convert(EW_ENCODING, "UTF-8", $str);
}

function ew_ConvertFromUtf8($str) {
	return ew_Convert("UTF-8", EW_ENCODING, $str);
}

function ew_Convert($from, $to, $str) {
	if (is_string($str) && $from != "" && $to != "" && strtoupper($from) != strtoupper($to)) {
		if (function_exists("iconv")) {
			return iconv($from, $to, $str);
		} elseif (function_exists("mb_convert_encoding")) {
			return mb_convert_encoding($str, $to, $from);
		} else {
			return $str;
		}
	} else {
		return $str;
	}
}

// Convert a value to JSON value
// $type: string/boolean
function ew_VarToJson($val, $type = "") {
	$type = strtolower($type);
	if (is_null($val)) {
		return "null";
	} elseif ($type == "boolean" || is_bool($val)) {
		return (ew_ConvertToBool($val)) ? "true" : "false";
	} elseif ($type == "string" || is_string($val)) {
		return "\"" . ew_JsEncode2($val) . "\"";
	}
	return $val;
}

// Convert rows (array) to JSON
function ew_ArrayToJson($ar, $offset = 0) {
	$arOut = array();
	$array = FALSE;
	if (count($ar) > 0) {
		$keys = array_keys($ar[0]);
		foreach ($keys as $key) {
			if (is_int($key)) {
				$array = TRUE;
				break;
			}
		}
	}
	foreach ($ar as $row) {
		$arwrk = array();
		foreach ($row as $key => $val) {
			if (($array && is_string($key)) || (!$array && is_int($key)))
				continue;
			$key = ($array) ? "" : "\"" . ew_JsEncode2($key) . "\":";
			$arwrk[] = $key . ew_VarToJson($val);
		}
		if ($array) { // Array
			$arOut[] = "[" . implode(",", $arwrk) . "]";
		} else { // Object
			$arOut[] = "{" . implode(",", $arwrk) . "}";
		}
	}
	if ($offset > 0)
		$arOut = array_slice($arOut, $offset);
	return "[" . implode(",", $arOut) . "]";
}

/**
 * Langauge class
 */

class cLanguage {
	var $LanguageId;
	var $Phrases = NULL;
	var $LanguageFolder = EW_LANGUAGE_FOLDER;

	// Constructor
	function __construct($langfolder = "", $langid = "") {
		global $gsLanguage;
		if ($langfolder <> "")
			$this->LanguageFolder = $langfolder;
		$this->LoadFileList(); // Set up file list
		if ($langid <> "") { // Set up language id
			$this->LanguageId = $langid;
			$_SESSION[EW_SESSION_LANGUAGE_ID] = $this->LanguageId;
		} elseif (@$_GET["language"] <> "") {
			$this->LanguageId = $_GET["language"];
			$_SESSION[EW_SESSION_LANGUAGE_ID] = $this->LanguageId;
		} elseif (@$_SESSION[EW_SESSION_LANGUAGE_ID] <> "") {
			$this->LanguageId = $_SESSION[EW_SESSION_LANGUAGE_ID];
		} else {
			$this->LanguageId = EW_LANGUAGE_DEFAULT_ID;
		}
		$gsLanguage = $this->LanguageId;
		$this->Load($this->LanguageId);
	}

	// Load language file list
	function LoadFileList() {
		global $EW_LANGUAGE_FILE;
		if (is_array($EW_LANGUAGE_FILE)) {
			$cnt = count($EW_LANGUAGE_FILE);
			for ($i = 0; $i < $cnt; $i++)
				$EW_LANGUAGE_FILE[$i][1] = $this->LoadFileDesc($this->LanguageFolder . $EW_LANGUAGE_FILE[$i][2]);
		}
	}

	// Load language file description
	function LoadFileDesc($File) {
		if (EW_USE_DOM_XML) {
			$this->Phrases = new cXMLDocument();
			if ($this->Phrases->Load($File))
				return $this->GetNodeAtt($this->Phrases->DocumentElement(), "desc");
		} else {
			$ar = ew_Xml2Array(substr(file_get_contents($File), 0, 512)); // Just read the first part
			return (is_array($ar)) ? @$ar['ew-language']['attr']['desc'] : "";
		}
	}

	// Load language file
	function Load($id) {
		global $DEFAULT_DECIMAL_POINT, $DEFAULT_THOUSANDS_SEP, $DEFAULT_MON_DECIMAL_POINT, $DEFAULT_MON_THOUSANDS_SEP,
			$DEFAULT_CURRENCY_SYMBOL, $DEFAULT_POSITIVE_SIGN, $DEFAULT_NEGATIVE_SIGN, $DEFAULT_FRAC_DIGITS,
			$DEFAULT_P_CS_PRECEDES, $DEFAULT_P_SEP_BY_SPACE, $DEFAULT_N_CS_PRECEDES, $DEFAULT_N_SEP_BY_SPACE,
			$DEFAULT_P_SIGN_POSN, $DEFAULT_N_SIGN_POSN, $USE_DEFAULT_LOCALE, $DEFAULT_LOCALE, $DEFAULT_TIME_ZONE;
		$sFileName = $this->GetFileName($id);
		if ($sFileName == "")
			$sFileName = $this->GetFileName(EW_LANGUAGE_DEFAULT_ID);
		if ($sFileName == "")
			return;
		if (EW_USE_DOM_XML) {
			$this->Phrases = new cXMLDocument();
			$this->Phrases->Load($sFileName);
		} else {
			if (is_array(@$_SESSION[EW_PROJECT_NAME . "_" . $sFileName])) {
				$this->Phrases = $_SESSION[EW_PROJECT_NAME . "_" . $sFileName];
			} else {
				$this->Phrases = ew_Xml2Array(file_get_contents($sFileName));
			}
		}

		// Set up locale / currency format for language
		if ($this->LocalePhrase("use_system_locale") == "1") { // Use system locale
			$langLocale = $this->LocalePhrase("locale");
			if ($langLocale <> "")
				@setlocale(LC_ALL, $langLocale); // Set language locale
			extract(ew_LocaleConv());
			if (!empty($decimal_point)) $DEFAULT_DECIMAL_POINT = $decimal_point;
			if (!empty($thousands_sep)) $DEFAULT_THOUSANDS_SEP = $thousands_sep;
			if (!empty($mon_decimal_point)) $DEFAULT_MON_DECIMAL_POINT = $mon_decimal_point;
			if (empty($DEFAULT_MON_DECIMAL_POINT)) $DEFAULT_MON_DECIMAL_POINT = $DEFAULT_DECIMAL_POINT;
			if (!empty($mon_thousands_sep)) $DEFAULT_MON_THOUSANDS_SEP = $mon_thousands_sep;
			if (empty($DEFAULT_MON_THOUSANDS_SEP)) $DEFAULT_MON_THOUSANDS_SEP = $DEFAULT_THOUSANDS_SEP;
			if (!empty($currency_symbol)) {
				if (EW_CHARSET == "utf-8") {
					if ($int_curr_symbol == "EUR" && ord($currency_symbol) == 128) {
						$currency_symbol = "\xe2\x82\xac";
					} elseif ($int_curr_symbol == "GBP" && ord($currency_symbol) == 163) {
						$currency_symbol = "\xc2\xa3";
					} elseif ($int_curr_symbol == "JPY" && ord($currency_symbol) == 92) {
						$currency_symbol = "\xc2\xa5";
					}
				}
				$DEFAULT_CURRENCY_SYMBOL = $currency_symbol;
			}
			if (!empty($positive_sign)) $DEFAULT_POSITIVE_SIGN = $positive_sign;
			if (!empty($negative_sign)) $DEFAULT_NEGATIVE_SIGN = $negative_sign;
			if (!empty($frac_digits) && $frac_digits <> CHAR_MAX) $DEFAULT_FRAC_DIGITS = $frac_digits;
			if (!empty($p_cs_precedes) && $p_cs_precedes <> CHAR_MAX) $DEFAULT_P_CS_PRECEDES = $p_cs_precedes;
			if (!empty($p_sep_by_space) && $p_sep_by_space <> CHAR_MAX) $DEFAULT_P_SEP_BY_SPACE = $p_sep_by_space;
			if (!empty($n_cs_precedes) && $n_cs_precedes <> CHAR_MAX) $DEFAULT_N_CS_PRECEDES = $n_cs_precedes;
			if (!empty($n_sep_by_space) && $n_sep_by_space <> CHAR_MAX) $DEFAULT_N_SEP_BY_SPACE = $n_sep_by_space;
			if (!empty($p_sign_posn) && $p_sign_posn <> CHAR_MAX) $DEFAULT_P_SIGN_POSN = $p_sign_posn;
			if (!empty($n_sign_posn) && $n_sign_posn <> CHAR_MAX) $DEFAULT_N_SIGN_POSN = $n_sign_posn;
		} else { // Use language file
			$ar = array("p_cs_precedes", "p_sep_by_space", "n_cs_precedes", "n_sep_by_space");
			foreach ($DEFAULT_LOCALE as $key => $value) {
				if ($this->LocalePhrase($key) <> "")
					$DEFAULT_LOCALE[$key] = in_array($key, $ar) ? $this->LocalePhrase($key) == "1" : $this->LocalePhrase($key);
			}
		}

		/**
		 * Time zone
		 * Read http://www.php.net/date_default_timezone_set for details
		 * and http://www.php.net/timezones for supported time zones
		*/

		// Set up time zone from language file for multi-language site
		if ($this->LocalePhrase("time_zone") <> "") $DEFAULT_TIME_ZONE = $this->LocalePhrase("time_zone");
		if (function_exists("date_default_timezone_set") && $DEFAULT_TIME_ZONE <> "")
			date_default_timezone_set($DEFAULT_TIME_ZONE);
	}

	// Get language file name
	function GetFileName($Id) {
		global $EW_LANGUAGE_FILE;
		if (is_array($EW_LANGUAGE_FILE)) {
			$cnt = count($EW_LANGUAGE_FILE);
			for ($i = 0; $i < $cnt; $i++)
				if ($EW_LANGUAGE_FILE[$i][0] == $Id) {
					return $this->LanguageFolder . $EW_LANGUAGE_FILE[$i][2];
				}
		}
		return "";
	}

	// Get node attribute
	function GetNodeAtt($Nodes, $Att) {
		$value = ($Nodes) ? $this->Phrases->GetAttribute($Nodes, $Att) : "";

		//return ew_ConvertFromUtf8($value);
		return $value;
	}

	// Set node attribute
	function SetNodeAtt($Nodes, $Att, $Value) {
		if ($Nodes)
			$this->Phrases->SetAttribute($Nodes, $Att, $Value);
	}

	// Get locale phrase
	function LocalePhrase($Id) {
		if (is_object($this->Phrases)) {
			return $this->GetNodeAtt($this->Phrases->SelectSingleNode("//locale/phrase[@id='" . strtolower($Id) . "']"), "value");
		} elseif (is_array($this->Phrases)) {
			return ew_ConvertFromUtf8(@$this->Phrases['ew-language']['locale']['phrase'][strtolower($Id)]['attr']['value']);
		}
	}

	// Set locale phrase
	function setLocalePhrase($Id, $Value) {
		if (is_object($this->Phrases)) {
			$this->SetNodeAtt($this->Phrases->SelectSingleNode("//locale/phrase[@id='" . strtolower($Id) . "']"), "value", $Value);
		} elseif (is_array($this->Phrases)) {
			$this->Phrases['ew-language']['locale']['phrase'][strtolower($Id)]['attr']['value'] = $Value;
		}
	}

	// Get phrase
	function Phrase($Id) {
		if (is_object($this->Phrases)) {
			$ImageUrl = $this->GetNodeAtt($this->Phrases->SelectSingleNode("//global/phrase[@id='" . strtolower($Id) . "']"), "imageurl");
			$ImageWidth = $this->GetNodeAtt($this->Phrases->SelectSingleNode("//global/phrase[@id='" . strtolower($Id) . "']"), "imagewidth");
			$ImageHeight = $this->GetNodeAtt($this->Phrases->SelectSingleNode("//global/phrase[@id='" . strtolower($Id) . "']"), "imageheight");
			$ImageClass = $this->GetNodeAtt($this->Phrases->SelectSingleNode("//global/phrase[@id='" . strtolower($Id) . "']"), "class");
			$Text = $this->GetNodeAtt($this->Phrases->SelectSingleNode("//global/phrase[@id='" . strtolower($Id) . "']"), "value");
		} elseif (is_array($this->Phrases)) {
			$ImageUrl = ew_ConvertFromUtf8(@$this->Phrases['ew-language']['global']['phrase'][strtolower($Id)]['attr']['imageurl']);
			$ImageWidth = ew_ConvertFromUtf8(@$this->Phrases['ew-language']['global']['phrase'][strtolower($Id)]['attr']['imagewidth']);
			$ImageHeight = ew_ConvertFromUtf8(@$this->Phrases['ew-language']['global']['phrase'][strtolower($Id)]['attr']['imageheight']);
			$ImageClass = ew_ConvertFromUtf8(@$this->Phrases['ew-language']['global']['phrase'][strtolower($Id)]['attr']['class']);
			$Text = ew_ConvertFromUtf8(@$this->Phrases['ew-language']['global']['phrase'][strtolower($Id)]['attr']['value']);
		}
		if ($ImageClass <> "") {
			return "<span data-phrase=\"" . $Id . "\" class=\"" . $ImageClass . "\" data-caption=\"" . ew_HtmlEncode($Text) . "\"></span>";
		} elseif ($ImageUrl <> "") {
			$style = ($ImageWidth <> "") ? " width: " . $ImageWidth . "px;" : "";
			$style .= ($ImageHeight <> "") ? " height: " . $ImageHeight . "px;" : "";
			return "<img data-phrase=\"" . $Id . "\" src=\"" . ew_HtmlEncode($ImageUrl) . "\" style=\"" . trim($style) . "\" alt=\"" . ew_HtmlEncode($Text) . "\" title=\"" . ew_HtmlEncode($Text) . "\">";
		} else {
			return $Text;
		}
	}

	// Set phrase
	function setPhrase($Id, $Value) {
		if (is_object($this->Phrases)) {
			$this->SetNodeAtt($this->Phrases->SelectSingleNode("//global/phrase[@id='" . strtolower($Id) . "']"), "value", $Value);
		} elseif (is_array($this->Phrases)) {
			$this->Phrases['ew-language']['global']['phrase'][strtolower($Id)]['attr']['value'] = $Value;
		}
	}

	// Get project phrase
	function ProjectPhrase($Id) {
		if (is_object($this->Phrases)) {
			return $this->GetNodeAtt($this->Phrases->SelectSingleNode("//project/phrase[@id='" . strtolower($Id) . "']"), "value");
		} elseif (is_array($this->Phrases)) {
			return ew_ConvertFromUtf8(@$this->Phrases['ew-language']['project']['phrase'][strtolower($Id)]['attr']['value']);
		}
	}

	// Set project phrase
	function setProjectPhrase($Id, $Value) {
		if (is_object($this->Phrases)) {
			$this->SetNodeAtt($this->Phrases->SelectSingleNode("//project/phrase[@id='" . strtolower($Id) . "']"), "value", $Value);
		} elseif (is_array($this->Phrases)) {
			$this->Phrases['ew-language']['project']['phrase'][strtolower($Id)]['attr']['value'] = $Value;
		}
	}

	// Get menu phrase
	function MenuPhrase($MenuId, $Id) {
		if (is_object($this->Phrases)) {
			return $this->GetNodeAtt($this->Phrases->SelectSingleNode("//project/menu[@id='" . $MenuId . "']/phrase[@id='" . strtolower($Id) . "']"), "value");
		} elseif (is_array($this->Phrases)) {
			return ew_ConvertFromUtf8(@$this->Phrases['ew-language']['project']['menu'][$MenuId]['phrase'][strtolower($Id)]['attr']['value']);
		}
	}

	// Set menu phrase
	function setMenuPhrase($MenuId, $Id, $Value) {
		if (is_object($this->Phrases)) {
			$this->SetNodeAtt($this->Phrases->SelectSingleNode("//project/menu[@id='" . $MenuId . "']/phrase[@id='" . strtolower($Id) . "']"), "value", $Value);
		} elseif (is_array($this->Phrases)) {
			$this->Phrases['ew-language']['project']['menu'][$MenuId]['phrase'][strtolower($Id)]['attr']['value'] = $Value;
		}
	}

	// Get table phrase
	function TablePhrase($TblVar, $Id) {
		if (is_object($this->Phrases)) {
			return $this->GetNodeAtt($this->Phrases->SelectSingleNode("//project/table[@id='" . strtolower($TblVar) . "']/phrase[@id='" . strtolower($Id) . "']"), "value");
		} elseif (is_array($this->Phrases)) {
			return ew_ConvertFromUtf8(@$this->Phrases['ew-language']['project']['table'][strtolower($TblVar)]['phrase'][strtolower($Id)]['attr']['value']);
		}
	}

	// Set table phrase
	function setTablePhrase($TblVar, $Id, $Value) {
		if (is_object($this->Phrases)) {
			$this->SetNodeAtt($this->Phrases->SelectSingleNode("//project/table[@id='" . strtolower($TblVar) . "']/phrase[@id='" . strtolower($Id) . "']"), "value", $Value);
		} elseif (is_array($this->Phrases)) {
			$this->Phrases['ew-language']['project']['table'][strtolower($TblVar)]['phrase'][strtolower($Id)]['attr']['value'] = $Value;
		}
	}

	// Get field phrase
	function FieldPhrase($TblVar, $FldVar, $Id) {
		if (is_object($this->Phrases)) {
			return $this->GetNodeAtt($this->Phrases->SelectSingleNode("//project/table[@id='" . strtolower($TblVar) . "']/field[@id='" . strtolower($FldVar) . "']/phrase[@id='" . strtolower($Id) . "']"), "value");
		} elseif (is_array($this->Phrases)) {
			return ew_ConvertFromUtf8(@$this->Phrases['ew-language']['project']['table'][strtolower($TblVar)]['field'][strtolower($FldVar)]['phrase'][strtolower($Id)]['attr']['value']);
		}
	}

	// Set field phrase
	function setFieldPhrase($TblVar, $FldVar, $Id, $Value) {
		if (is_object($this->Phrases)) {
			$this->SetNodeAtt($this->Phrases->SelectSingleNode("//project/table[@id='" . strtolower($TblVar) . "']/field[@id='" . strtolower($FldVar) . "']/phrase[@id='" . strtolower($Id) . "']"), "value", $Value);
		} elseif (is_array($this->Phrases)) {
			$this->Phrases['ew-language']['project']['table'][strtolower($TblVar)]['field'][strtolower($FldVar)]['phrase'][strtolower($Id)]['attr']['value'] = $Value;
		}
	}

	// Output XML as JSON
	function XmlToJSON($XPath) {
		$NodeList = $this->Phrases->SelectNodes($XPath);
		$Str = "{";
		foreach ($NodeList as $Node) {
			$Id = $this->GetNodeAtt($Node, "id");
			$Value = $this->GetNodeAtt($Node, "value");
			$Str .= "\"" . ew_JsEncode2($Id) . "\":\"" . ew_JsEncode2($Value) . "\",";
		}
		if (substr($Str, -1) == ",") $Str = substr($Str, 0, strlen($Str)-1);
		$Str .= "}";
		return $Str;
	}

	// Output array as JSON
	function ArrayToJSON($client) {
		$ar = @$this->Phrases['ew-language']['global']['phrase'];
		$Str = "{";
		if (is_array($ar)) {
			foreach ($ar as $id => $node) {
				$is_client = @$node['attr']['client'] == '1';
				$value = ew_ConvertFromUtf8(@$node['attr']['value']);
				if (!$client || ($client && $is_client))
					$Str .= "\"" . ew_JsEncode2($id) . "\":\"" . ew_JsEncode2($value) . "\",";
			}
		}
		if (substr($Str, -1) == ",") $Str = substr($Str, 0, strlen($Str)-1);
		$Str .= "}";
		return $Str;
	}

	// Output all phrases as JSON
	function AllToJSON() {
		if (is_object($this->Phrases)) {
			return "var ewLanguage = new ew_Language(" . $this->XmlToJSON("//global/phrase") . ");";
		} elseif (is_array($this->Phrases)) {
			return "var ewLanguage = new ew_Language(" . $this->ArrayToJSON(FALSE) . ");";
		}
	}

	// Output client phrases as JSON
	function ToJSON() {
		if (is_object($this->Phrases)) {
			return "var ewLanguage = new ew_Language(" . $this->XmlToJSON("//global/phrase[@client='1']") . ");";
		} elseif (is_array($this->Phrases)) {
			return "var ewLanguage = new ew_Language(" . $this->ArrayToJSON(TRUE) . ");";
		}
	}

	// Output language selection form
	function SelectionForm() {
		global $EW_LANGUAGE_FILE, $gsLanguage;
		$form = "";
		if (is_array($EW_LANGUAGE_FILE)) {
			$cnt = count($EW_LANGUAGE_FILE);
			if ($cnt > 1) {
				for ($i = 0; $i < $cnt; $i++) {
					$langid = $EW_LANGUAGE_FILE[$i][0];
					$langphrase = $EW_LANGUAGE_FILE[$i][1];
					$selected = ($langid == $gsLanguage) ? " selected=\"selected\"" : "";
					$phrase = $this->Phrase($langid);
					if ($phrase == "") // Use description for button
						$phrase = $langphrase;
					$form .= "<option value=\"" . $langid . "\"" . $selected . ">" . $phrase . "</option>";
				}
			}
		}
		if ($form <> "")
			$form = "<div class=\"ewLanguageOption\"><select class=\"form-control\" id=\"ewLanguage\" name=\"ewLanguage\" onchange=\"ew_SetLanguage(this);\">" . $form . "</select></div>";
		return $form;
	}
}

/**
 * XML document class
 */

class cXMLDocument {
	var $Encoding = "utf-8";
	var $RootTagName;
	var $SubTblName = '';
	var $RowTagName;
	var $XmlDoc = FALSE;
	var $XmlTbl;
	var $XmlSubTbl;
	var $XmlRow;
	var $NullValue = 'NULL';

	function cXMLDocument($encoding = "") {
		if ($encoding <> "")
			$this->Encoding = $encoding;
		if ($this->Encoding <> "") {
			$this->XmlDoc = new DOMDocument("1.0", strval($this->Encoding));
		} else {
			$this->XmlDoc = new DOMDocument("1.0");
		}
	}

	function Load($filename) {
		$filepath = realpath($filename);
		return file_exists($filepath) ? $this->XmlDoc->load($filepath) : FALSE;
	}

	function &DocumentElement() {
		$de = $this->XmlDoc->documentElement;
		return $de;
	}

	function GetAttribute($element, $name) {
		return ($element) ? ew_ConvertFromUtf8($element->getAttribute($name)) : "";
	}

	function SetAttribute($element, $name, $value) {
		if ($element)
			$element->setAttribute($name, ew_ConvertToUtf8($value));
    }

	function SelectSingleNode($query) {
		$elements = $this->SelectNodes($query);
		return ($elements->length > 0) ? $elements->item(0) : NULL;
	}

	function SelectNodes($query) {
		$xpath = new DOMXPath($this->XmlDoc);
		return $xpath->query($query);
	}

	function AddRoot($roottagname = 'table') {
		$this->RootTagName = ew_XmlTagName($roottagname);
		$this->XmlTbl = $this->XmlDoc->createElement($this->RootTagName);
		$this->XmlDoc->appendChild($this->XmlTbl);
	}

	function AddRow($tabletagname = '', $rowtagname = 'row') {
		$this->RowTagName = ew_XmlTagName($rowtagname);
		$this->XmlRow = $this->XmlDoc->createElement($this->RowTagName);
		if ($tabletagname == '') {
			if ($this->XmlTbl)
				$this->XmlTbl->appendChild($this->XmlRow);
		} else {
			if ($this->SubTblName == '' || $this->SubTblName != $tabletagname) {
				$this->SubTblName = ew_XmlTagName($tabletagname);
				$this->XmlSubTbl = $this->XmlDoc->createElement($this->SubTblName);
				$this->XmlTbl->appendChild($this->XmlSubTbl);
			}
			if ($this->XmlSubTbl)
				$this->XmlSubTbl->appendChild($this->XmlRow);
		}
	}

	function AddField($name, $value) {
		if (is_null($value)) $value = $this->NullValue;
		$value = ew_ConvertToUtf8($value); // Convert to UTF-8
		$xmlfld = $this->XmlDoc->createElement(ew_XmlTagName($name));
		$this->XmlRow->appendChild($xmlfld);
		$xmlfld->appendChild($this->XmlDoc->createTextNode($value));
	}

	function XML() {
		return $this->XmlDoc->saveXML();
	}
}

/**
 * Menu class
 */

class cMenu {
	var $Id;
	var $MenuBarClassName = EW_MENUBAR_CLASSNAME;
	var $MenuClassName = EW_MENU_CLASSNAME;
	var $SubMenuClassName = EW_SUBMENU_CLASSNAME;
	var $SubMenuDropdownImage = EW_SUBMENU_DROPDOWN_IMAGE;
	var $SubMenuDropdownIconClassName = EW_SUBMENU_DROPDOWN_ICON_CLASSNAME;
	var $MenuDividerClassName = EW_MENU_DIVIDER_CLASSNAME;
	var $MenuItemClassName = EW_MENU_ITEM_CLASSNAME;
	var $SubMenuItemClassName = EW_SUBMENU_ITEM_CLASSNAME;
	var $MenuActiveItemClassName = EW_MENU_ACTIVE_ITEM_CLASS;
	var $SubMenuActiveItemClassName = EW_SUBMENU_ACTIVE_ITEM_CLASS;
	var $MenuRootGroupTitleAsSubMenu = EW_MENU_ROOT_GROUP_TITLE_AS_SUBMENU;
	var $ShowRightMenu = EW_SHOW_RIGHT_MENU;
	var $MenuLinkDropdownClass = "";
	var $MenuLinkClassName = "";
	var $IsMobile = FALSE;
	var $IsRoot = FALSE;
	var $NoItem = NULL;
	var $ItemData = array();

	function __construct($id, $mobile = FALSE) {
		$this->Id = $id;
		$this->IsMobile = $mobile;
	}

	// Add a menu item
	function AddMenuItem($id, $name, $text, $url, $parentid = -1, $src = "", $allowed = TRUE, $grouptitle = FALSE, $customurl = FALSE) {
		if (is_int($url) && is_bool($src)) { // For backward compatibility (without the $name argument)
			list($text, $url, $parentid, $src, $allowed, $grouptitle, $customurl) = array($name, $text, $url, $parentid, $src, $allowed, $grouptitle);
			$name = "mi_" . $id;
		}
		$item = new cMenuItem($id, $name, $text, $url, $parentid, $src, $allowed, $grouptitle, $customurl);
		$item->Parent = &$this;

		// Fire MenuItem_Adding event
		if (function_exists("MenuItem_Adding") && !MenuItem_Adding($item))
			return;
		if ($item->ParentId < 0) {
			$this->AddItem($item);
		} else {
			if ($oParentMenu = &$this->FindItem($item->ParentId))
				$oParentMenu->AddItem($item, $this->IsMobile);
		}
	}

	// Add item to internal array
	function AddItem($item) {
		$this->ItemData[] = $item;
	}

	// Clear all menu items
	function Clear() {
		$this->ItemData = array();
	}

	// Find item
	function &FindItem($id) {
		$cnt = count($this->ItemData);
		for ($i = 0; $i < $cnt; $i++) {
			$item = &$this->ItemData[$i];
			if ($item->Id == $id) {
				return $item;
			} elseif (!is_null($item->SubMenu)) {
				if ($subitem = &$item->SubMenu->FindItem($id))
					return $subitem;
			}
		}
		$noitem = $this->NoItem;
		return $noitem;
	}

	// Find item by menu text
	function &FindItemByText($txt) {
		$cnt = count($this->ItemData);
		for ($i = 0; $i < $cnt; $i++) {
			$item = &$this->ItemData[$i];
			if ($item->Text == $txt) {
				return $item;
			} elseif (!is_null($item->SubMenu)) {
				if ($subitem = &$item->SubMenu->FindItemByText($txt))
					return $subitem;
			}
		}
		$noitem = $this->NoItem;
		return $noitem;
	}

	// Get menu item count
	function Count() {
		return count($this->ItemData);
	}

	// Move item to position
	function MoveItem($Text, $Pos) {
		$cnt = count($this->ItemData);
		if ($Pos < 0) {
			$Pos = 0;
		} elseif ($Pos >= $cnt) {
			$Pos = $cnt - 1;
		}
		$item = NULL;
		$cnt = count($this->ItemData);
		for ($i = 0; $i < $cnt; $i++) {
			if ($this->ItemData[$i]->Text == $Text) {
				$item = $this->ItemData[$i];
				break;
			}
		}
		if ($item) {
			unset($this->ItemData[$i]);
			$this->ItemData = array_merge(array_slice($this->ItemData, 0, $Pos),
				array($item), array_slice($this->ItemData, $Pos));
		}
	}

	// Check if sub menu should be shown
	function RenderSubMenu($item) {
		if (!is_null($item->SubMenu)) {
			foreach ($item->SubMenu->ItemData as $subitem) {
				if ($item->SubMenu->RenderItem($subitem))
					return TRUE;
			}
		}
		return FALSE;
	}

	// Check if a menu item should be shown
	function RenderItem($item) {
		if (!is_null($item->SubMenu)) {
			foreach ($item->SubMenu->ItemData as $subitem) {
				if ($item->SubMenu->RenderItem($subitem))
					return TRUE;
			}
		}
		return ($item->Allowed && $item->Url <> "");
	}

	// Check if this menu should be rendered
	function RenderMenu() {
		foreach ($this->ItemData as $item) {
			if ($this->RenderItem($item))
				return TRUE;
		}
		return FALSE;
	}

	// Render the menu
	function Render($ret = FALSE) {
		if (function_exists("Menu_Rendering") && $this->IsRoot) Menu_Rendering($this);
		if (!$this->RenderMenu())
			return;
		if (!$this->IsMobile) {
			if ($this->IsRoot) {
				$str = "<ul";
				if ($this->Id <> "") {
					if (is_numeric($this->Id)) {
						$str .= " id=\"menu_" . $this->Id . "\"";
					} else {
						$str .= " id=\"" . $this->Id . "\"";
					}
				}
				$str .= " class=\"" . $this->MenuClassName . "\">\n";
			} else {
				$str = "<ul class=\"" . $this->SubMenuClassName . "\" role=\"menu\">\n";
			}
		} else {
			$str = "";
		}
		$gcnt = 0; // Group count
		$gtitle = FALSE; // Last item is group title
		$i = 0; // Menu item count
		$cururl = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		foreach ($this->ItemData as $item) {
			if ($this->RenderItem($item)) {
				$i++;
				if (!$this->IsMobile && $gtitle && ($gcnt >= 1 || $this->IsRoot)) // add divider for previous group
					$str .= "<li class=\"" . $this->MenuDividerClassName . "\"></li>\n";
				if ($item->GroupTitle && (!$this->IsRoot || !$this->MenuRootGroupTitleAsSubMenu)) { // Group title
					$gtitle = TRUE;
					$gcnt += 1;
					if (strval($item->Text) <> "") {
						if ($this->IsMobile)
							$str .= "<li data-role=\"list-divider\">" . $item->Text . "</li>\n";
						else
							$str .= "<li class=\"dropdown-header\">" . $item->Text . "</li>\n";
					}
					if (!is_null($item->SubMenu)) {
						foreach ($item->SubMenu->ItemData as $subitem) {
							$liclass = !is_null($subitem->SubMenu) && $this->RenderSubMenu($subitem) ? $this->SubMenuItemClassName : "";
							$aclass = "";
							if (!$subitem->IsCustomUrl && ew_CurrentPage() == ew_GetPageName($subitem->Url) || $subitem->IsCustomUrl && $cururl == $subitem->Url) {
								ew_AppendClass($liclass, $this->MenuActiveItemClassName);
								$subitem->Url = "javascript:void(0);";
							}
							if ($this->RenderItem($subitem)) {
								if ($this->IsMobile && $item->GroupTitle)
									ew_AppendClass($aclass, "ewIndent");
								$str .= $subitem->Render($aclass, $liclass, $this->IsMobile) . "\n"; // Create <LI>
							}
						}
					}
				} else {
					$gtitle = FALSE;
					$liclass = !is_null($item->SubMenu) && $this->RenderSubMenu($item) ? ($this->IsRoot ? $this->MenuItemClassName : $this->SubMenuItemClassName) : "";
					$aclass = "";
					if (!$item->IsCustomUrl && ew_CurrentPage() == ew_GetPageName($item->Url) || $item->IsCustomUrl && $cururl == $item->Url) {
						if ($this->IsRoot)
							ew_AppendClass($liclass, $this->MenuActiveItemClassName);
						else
							ew_AppendClass($liclass, $this->SubMenuActiveItemClassName);
						$item->Url = "javascript:void(0);";
					}
					$str .= $item->Render($aclass, $liclass, $this->IsMobile) . "\n"; // Create <LI>
				}
			}
		}
		if ($this->IsMobile) {
			$str = "<ul data-role=\"listview\" data-filter=\"true\">" . $str . "</ul>\n";
		} elseif ($this->IsRoot) {
			$str .= "</ul>\n";
			if (EW_MENUBAR_BRAND <> "") {
				$brandhref = (EW_MENUBAR_BRAND_HYPERLINK == "") ? "#" : EW_MENUBAR_BRAND_HYPERLINK;
				$str = "<a class=\"navbar-brand hidden-xs\" href=\"" . ew_HtmlEncode($brandhref) . "\">" . EW_MENUBAR_BRAND . "</a>" . $str;
			}

			// Add right menu
			if ($this->ShowRightMenu)
				$str .= "<ul class=\"nav navbar-nav navbar-right\"></ul>";
			if ($this->MenuBarClassName <> "")
				$str = "<div class=\"" . $this->MenuBarClassName . "\">" . $str . "</div>";
		} else {
			$str .= "</ul>\n";
		}
		if ($ret) // Return as string
			return $str;
		echo $str; // Output
	}
}

// Menu item class
class cMenuItem {
	var $Id;
	var $Name;
	var $Text;
	var $Url;
	var $ParentId; 
	var $SubMenu = NULL; // Data type = cMenu
	var $Source;
	var $Allowed = TRUE;
	var $Target;
	var $GroupTitle;
	var $IsCustomUrl;
	var $Parent;

	// Constructor
	function __construct($id, $name, $text, $url, $parentid = -1, $src = "", $allowed = TRUE, $grouptitle = FALSE, $customurl = FALSE) {
		$this->Id = $id;
		$this->Name = $name;
		$this->Text = $text;
		$this->Url = $url;
		$this->ParentId = $parentid;
		$this->Source = $src;
		$this->Allowed = $allowed;
		$this->GroupTitle = $grouptitle;
		$this->IsCustomUrl = $customurl;
	}

	// Add submenu item
	function AddItem($item, $mobile = FALSE) {
		if (is_null($this->SubMenu)) {
			$this->SubMenu = new cMenu($this->Id, $mobile);
			$this->SubMenu->MenuBarClassName = $this->Parent->MenuBarClassName;
			$this->SubMenu->MenuClassName = $this->Parent->MenuClassName;
			$this->SubMenu->SubMenuClassName = $this->Parent->SubMenuClassName;
			$this->SubMenu->SubMenuDropdownImage = $this->Parent->SubMenuDropdownImage;
			$this->SubMenu->SubMenuDropdownIconClassName = $this->Parent->SubMenuDropdownIconClassName;
			$this->SubMenu->MenuDividerClassName = $this->Parent->MenuDividerClassName;
			$this->SubMenu->MenuItemClassName = $this->Parent->MenuItemClassName;
			$this->SubMenu->SubMenuItemClassName = $this->Parent->SubMenuItemClassName;
			$this->SubMenu->MenuActiveItemClassName = $this->Parent->MenuActiveItemClassName;
			$this->SubMenu->SubMenuActiveItemClassName = $this->Parent->SubMenuActiveItemClassName;
			$this->SubMenu->MenuRootGroupTitleAsSubMenu = $this->Parent->MenuRootGroupTitleAsSubMenu;
			$this->SubMenu->MenuLinkDropdownClass = $this->Parent->MenuLinkDropdownClass;
			$this->SubMenu->MenuLinkClassName = $this->Parent->MenuLinkClassName;
		}
		$this->SubMenu->AddItem($item);
	}

	// Render
	function Render($aclass = "", $liclass = "", $mobile = FALSE) {

		// Create <A>
		$url = ew_GetUrl($this->Url);
		if (!is_null($this->SubMenu))
			$submenuhtml = $this->SubMenu->Render(TRUE);
		else
			$submenuhtml = "";
		if ($mobile) {
			$url = str_replace("#","?chart=",$url);
			if ($url == "") $url = "#";
			$attrs = array("class" => $aclass, "rel" => ($url != "#") ? "external" : "", "href" => $url, "target" => $this->Target);
		} else {
			if ($url == "") $url = "#";
			if (!is_null($this->SubMenu) && $this->SubMenu->MenuLinkDropdownClass <> "" && $submenuhtml <> "")
				ew_PrependClass($aclass, $this->SubMenu->MenuLinkDropdownClass);
			$attrs = array("class" => $aclass, "href" => $url, "target" => $this->Target);
		}
		$text = $this->Text;
		if (!is_null($this->SubMenu) && $submenuhtml <> "") {
			if ($this->Parent->SubMenuDropdownIconClassName <> "")
				$text .= "<span class=\"" . $this->Parent->SubMenuDropdownIconClassName . "\"></span>";
			if ($this->Parent->SubMenuDropdownImage <> "" && $this->ParentId == -1)
				$text .= $this->Parent->SubMenuDropdownImage;
		}
		$innerhtml = ew_HtmlElement("a", $attrs, $text);
		if (!is_null($this->SubMenu)) {
			if ($url <> "#" && $this->SubMenu->MenuLinkClassName <> "" && $submenuhtml <> "") { // Add click link for mobile menu
				$attrs2 = array("class" => "ewMenuLink", "href" => $url);
				$text2 = "<span class=\"" . $this->SubMenu->MenuLinkClassName . "\"></span>";
				$innerhtml = ew_HtmlElement("a", $attrs2, $text2) . $innerhtml;
			}
			if ($mobile && $this->Url <> "#")
				$innerhtml .= $innerhtml;
			$innerhtml .= $submenuhtml;
		}

		// Create <LI>
		return ew_HtmlElement("li", array("id" => $this->Name, "class" => $liclass), $innerhtml);
	}
}

// Menu Rendering event
function Menu_Rendering(&$Menu) {

	// Change menu items here
}

// MenuItem Adding event
function MenuItem_Adding(&$Item) {

	//var_dump($Item);
	// Return FALSE if menu item not allowed

	return TRUE;
}

// Output SCRIPT tag
function ew_AddClientScript($src, $attrs = NULL) {
	$atts = array("type"=>"text/javascript", "src"=>$src);
	if (is_array($attrs))
		$atts = array_merge($atts, $attrs);
	echo ew_HtmlElement("script", $atts, "") . "\n";
}

// Output LINK tag
function ew_AddStylesheet($href, $attrs = NULL) {
	$atts = array("rel"=>"stylesheet", "type"=>"text/css", "href"=>$href);
	if (is_array($attrs))
		$atts = array_merge($atts, $attrs);
	echo ew_HtmlElement("link", $atts, "", FALSE) . "\n";
}

// Build HTML element
function ew_HtmlElement($tagname, $attrs, $innerhtml = "", $endtag = TRUE) {
	$html = "<" . $tagname;
	if (is_array($attrs)) {
		foreach ($attrs as $name => $attr) {
			if (strval($attr) <> "")
				$html .= " " . $name . "=\"" . ew_HtmlEncode($attr) . "\"";
		}
	}
	$html .= ">";
	if (strval($innerhtml) <> "")
		$html .= $innerhtml;
	if ($endtag)
		$html .= "</" . $tagname . ">";
	return $html;
}

// Encode html
function ew_HtmlEncode($exp) {
	return @htmlspecialchars(strval($exp), ENT_COMPAT | ENT_HTML5, EW_ENCODING);
}

// Get title
function ew_HtmlTitle($name) {
	if (preg_match('/\s+title\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $name, $matches)) { // Match title='title'
		return $matches[1];
	} elseif (preg_match('/\s+data-caption\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $name, $matches)) { // Match data-caption='caption'
		return $matches[1];
	} else {
		return $name;
	}
}

// Get title and image
function ew_HtmlImageAndText($name) {
	if (preg_match('/<span([^>]*)>([\s\S]*?)<\/span\s*>/i', $name) || preg_match('/<img([^>]*)>/i', $name))
		$title = ew_HtmlTitle($name);
	else
		$title = $name;
	return ($title <> $name) ? $name . "&nbsp;" . $title : $name;
}

// XML tag name
function ew_XmlTagName($name) {
	if (!preg_match('/\A(?!XML)[a-z][\w0-9-]*/i', $name))
		$name = "_" . $name;
	return $name;
}

// Debug timer
class cTimer {
	var $StartTime;
	var $EndTime;

	function cTimer($start = TRUE) {
		if ($start)
			$this->Start();
	}

	function GetTime() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	// Get script start time
	function Start() {
		if (EW_DEBUG_ENABLED)
			$this->StartTime = $this->GetTime();
	}

	// Display elapsed time (in seconds)
	function Stop() {
		if (EW_DEBUG_ENABLED)
			$this->EndTime = $this->GetTime();
		if (isset($this->EndTime) && isset($this->StartTime) &&
			$this->EndTime > $this->StartTime)
			echo "<div class=\"alert alert-info ewAlert\">Page processing time: " . ($this->EndTime - $this->StartTime) . " seconds</div>";
	}
}

// Convert XML to array
function ew_Xml2Array($contents) {
	if (!$contents) return array(); 
	if (!function_exists('xml_parser_create')) return FALSE;
	$get_attributes = 1; // Always get attributes. DO NOT CHANGE!

	// Get the XML Parser of PHP
	$parser = xml_parser_create();
	xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); // Always return in utf-8
	xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	xml_parse_into_struct($parser, trim($contents), $xml_values);
	xml_parser_free($parser);
	if (!$xml_values) return;
	$xml_array = array();
	$parents = array();
	$opened_tags = array();
	$arr = array();
	$current = &$xml_array;
	$repeated_tag_index = array(); // Multiple tags with same name will be turned into an array
	foreach ($xml_values as $data) {
		unset($attributes, $value); // Remove existing values

		// Extract these variables into the foreach scope
		// - tag(string), type(string), level(int), attributes(array)

		extract($data);
		$result = array();
		if (isset($value))
			$result['value'] = $value; // Put the value in a assoc array

		// Set the attributes
		if (isset($attributes) and $get_attributes) {
			foreach ($attributes as $attr => $val)
				$result['attr'][$attr] = $val; // Set all the attributes in a array called 'attr'
		} 

		// See tag status and do the needed
		if ($type == "open") { // The starting of the tag '<tag>'
			$parent[$level-1] = &$current;
			if (!is_array($current) || !in_array($tag, array_keys($current))) { // Insert New tag
				if ($tag <> 'ew-language' && @$result['attr']['id'] <> '') { // 
					$last_item_index = $result['attr']['id'];
					$current[$tag][$last_item_index] = $result;
					$repeated_tag_index[$tag.'_'.$level] = 1;
					$current = &$current[$tag][$last_item_index];
				} else {
					$current[$tag] = $result;
					$repeated_tag_index[$tag.'_'.$level] = 0;
					$current = &$current[$tag];
				}
			} else { // Another element with the same tag name
				if ($repeated_tag_index[$tag.'_'.$level] > 0) { // If there is a 0th element it is already an array
					if (@$result['attr']['id'] <> '') {
						$last_item_index = $result['attr']['id'];
					} else {
						$last_item_index = $repeated_tag_index[$tag.'_'.$level];
					}
					$current[$tag][$last_item_index] = $result;
					$repeated_tag_index[$tag.'_'.$level]++;
				} else { // Make the value an array if multiple tags with the same name appear together
					$temp = $current[$tag];
					$current[$tag] = array();
					if (@$temp['attr']['id'] <> '') {
						$current[$tag][$temp['attr']['id']] = $temp;
					} else {
						$current[$tag][] = $temp;
					}
					if (@$result['attr']['id'] <> '') {
						$last_item_index = $result['attr']['id'];
					} else {
						$last_item_index = 1;
					}
					$current[$tag][$last_item_index] = $result;
					$repeated_tag_index[$tag.'_'.$level] = 2;
				} 
				$current = &$current[$tag][$last_item_index];
			}
		} elseif ($type == "complete") { // Tags that ends in one line '<tag>'
			if (!isset($current[$tag])) { // New key
				$current[$tag] = array(); // Always use array for "complete" type
				if (@$result['attr']['id'] <> '') {
					$current[$tag][$result['attr']['id']] = $result;
				} else {
					$current[$tag][] = $result;
				}
				$repeated_tag_index[$tag.'_'.$level] = 1;
			} else { // Existing key
				if (@$result['attr']['id'] <> '') {
			  	$current[$tag][$result['attr']['id']] = $result;
				} else {
					$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
				}
			  $repeated_tag_index[$tag.'_'.$level]++;
			}
		} elseif ($type == 'close') { // End of tag '</tag>'
			$current = &$parent[$level-1];
		}
	}
	return($xml_array);
}

// Encode value for double-quoted Javascript string
function ew_JsEncode2($val) {
	$val = strval($val);
	if (EW_IS_DOUBLE_BYTE)
		$val = ew_ConvertToUtf8($val);
	$val = str_replace("\\", "\\\\", $val);
	$val = str_replace("\"", "\\\"", $val);
	$val = str_replace("\t", "\\t", $val);
	$val = str_replace("\r", "\\r", $val);
	$val = str_replace("\n", "\\n", $val);
	if (EW_IS_DOUBLE_BYTE)
		$val = ew_ConvertFromUtf8($val);
	return $val;
}

// Encode value to single-quoted Javascript string for HTML attributes
function ew_JsEncode3($val) {
	$val = strval($val);
	if (EW_IS_DOUBLE_BYTE)
		$val = ew_ConvertToUtf8($val);
	$val = str_replace("\\", "\\\\", $val);
	$val = str_replace("'", "\\'", $val);
	$val = str_replace("\"", "&quot;", $val);
	if (EW_IS_DOUBLE_BYTE)
		$val = ew_ConvertFromUtf8($val);
	return $val;
}

// Convert array to JSON for HTML attributes
function ew_ArrayToJsonAttr($ar) {
	$Str = "{";
	foreach ($ar as $key => $val)
		$Str .= $key . ":'" . ew_JsEncode3($val) . "',";
	if (substr($Str, -1) == ",") $Str = substr($Str, 0, strlen($Str)-1);
	$Str .= "}";
	return $Str;
}

// Get current page name
function ew_CurrentPage() {
	return ew_GetPageName(ew_ScriptName());
}

// Get page name
function ew_GetPageName($url) {
	$PageName = "";
	if ($url <> "") {
		$PageName = $url;
		$p = strpos($PageName, "?");
		if ($p !== FALSE)
			$PageName = substr($PageName, 0, $p); // Remove QueryString
		$p = strrpos($PageName, "/");
		if ($p !== FALSE)
			$PageName = substr($PageName, $p+1); // Remove path
	}
	return $PageName;
}

// Get current user levels as array of user level IDs
function CurrentUserLevels() {
	global $Security;
	if (isset($Security)) {
		return $Security->UserLevelID;
	} else {
		if (isset($_SESSION[EW_SESSION_USER_LEVEL_ID])) {
			return array($_SESSION[EW_SESSION_USER_LEVEL_ID]);
		} else {
			return array();
		}
	}
}

// Check if menu item is allowed for current user level
function AllowListMenu($TableName) {
	$userlevels = CurrentUserLevels(); // Get user level ID list as array
	if (IsLoggedIn()) {
		if (in_array("-1", $userlevels)) {
			return TRUE;
		} else {
			$priv = 0;
			if (is_array(@$_SESSION[EW_SESSION_AR_USER_LEVEL_PRIV])) {
				foreach ($_SESSION[EW_SESSION_AR_USER_LEVEL_PRIV] as $row) {
					if (strval($row[0]) == strval($TableName) &&
						in_array($row[1], $userlevels)) {
						$thispriv = $row[2];
						if (is_null($thispriv))
							$thispriv = 0;
						$thispriv = intval($thispriv);
						$priv = $priv | $thispriv;
					}
				}
			}
			return ($priv & EW_ALLOW_LIST);
		}
	} else {
		return FALSE;
	}
}

// Get script name
if (!function_exists("ew_ScriptName")) {

	function ew_ScriptName() {
		$sn = ew_ServerVar("PHP_SELF");
		if (empty($sn)) $sn = ew_ServerVar("SCRIPT_NAME");
		if (empty($sn)) $sn = ew_ServerVar("ORIG_PATH_INFO");
		if (empty($sn)) $sn = ew_ServerVar("ORIG_SCRIPT_NAME");
		if (empty($sn)) $sn = ew_ServerVar("REQUEST_URI");
		if (empty($sn)) $sn = ew_ServerVar("URL");
		if (empty($sn)) $sn = "UNKNOWN";
		return $sn;
	}
}

// Get server variable by name
function ew_ServerVar($Name) {
	$str = @$_SERVER[$Name];
	if (empty($str)) $str = @$_ENV[$Name];
	return $str;
}

// Get jQuery files host
function ew_jQueryHost() {
	return "jquery/"; // Use local files
}

// Get jQuery version
function ew_jQueryFile($f) {
	$v = "1.11.1"; // Get jQuery version
	return str_replace("%v", $v, ew_jQueryHost() . $f);
}

// Get css file
function ew_CssFile($f) {
	if (EW_CSS_FLIP)
		return preg_replace('/(.css)$/i', "-rtl.css", $f);
	else
		return $f;
}

// Check if HTTPS
function ew_IsHttps() {
	return (ew_ServerVar("HTTPS") <> "" && ew_ServerVar("HTTPS") <> "off");
}

// Get domain URL
function ew_DomainUrl() {
	$sUrl = "http";
	$bSSL = ew_IsHttps();
	$sPort = strval(ew_ServerVar("SERVER_PORT"));
	$defPort = ($bSSL) ? "443" : "80";
	$sPort = ($sPort == $defPort) ? "" : ":$sPort";
	$sUrl .= ($bSSL) ? "s" : "";
	$sUrl .= "://";
	$sUrl .= ew_ServerVar("SERVER_NAME") . $sPort;
	return $sUrl;
}

// Get full URL
function ew_FullUrl() {
	return ew_DomainUrl() . ew_ScriptName();
}

// Get current URL
function ew_CurrentUrl() {
	$s = ew_ScriptName();
	$q = ew_ServerVar("QUERY_STRING");
	if ($q <> "") $s .= "?" . $q;
	return $s;
}

// Convert to full URL
function ew_ConvertFullUrl($url) {
	if ($url == "") return "";
	$sUrl = ew_FullUrl();
	return substr($sUrl, 0, strrpos($sUrl, "/")+1) . $url;
}

// Get relative url
function ew_GetUrl($url) {
	global $EW_RELATIVE_PATH;
	if ($url != "" && strpos($url, "://") === FALSE && strpos($url, "\\") === FALSE && strpos($url, "javascript:") === FALSE) {
		$path = "";
		if (strrpos($url, "/") !== FALSE) {
			$path = substr($url, 0, strrpos($url, "/"));
			$url = substr($url, strrpos($url, "/")+1); 
		}
		$path = ew_PathCombine($EW_RELATIVE_PATH, $path, FALSE);
		if ($path <> "") $path = ew_IncludeTrailingDelimiter($path, FALSE);
		return $path . $url;
	} else {
		return $url;
	}
}

// Include mobiledetect.php
include_once("mobile_detect.php");

// Check if mobile device
function ew_IsMobile() {
	global $MobileDetect;
	if (!isset($MobileDetect))
		$MobileDetect = new Mobile_Detect;
	return $MobileDetect->isMobile();
}

// Check if responsive layout
function ew_IsResponsiveLayout() {
	return $GLOBALS['EW_USE_RESPONSIVE_LAYOUT'];
}

// Execute UPDATE, INSERT, or DELETE statements
if (!function_exists('ew_Execute')) {

	function ew_Execute($SQL, $fn = NULL) {
		global $conn;
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($SQL);
		$conn->raiseErrorFn = '';
		if (is_callable($fn) && $rs) {
			while (!$rs->EOF) {
				$fn($rs->fields);
				$rs->MoveNext();
			}
			$rs->MoveFirst();
		}
		return $rs;
	}
}

// Executes the query, and returns the first column of the first row
if (!function_exists('ew_ExecuteScalar')) {

	function ew_ExecuteScalar($SQL) {
		$res = FALSE;
		$rs = ew_LoadRecordset($SQL);
		if ($rs && !$rs->EOF && $rs->FieldCount() > 0) {
			$res = $rs->fields[0];
			$rs->Close();
		}
		return $res;
	}
}

// Executes the query, and returns the first row
if (!function_exists('ew_ExecuteRow')) {

	function ew_ExecuteRow($SQL) {
		$res = FALSE;
		$rs = ew_LoadRecordset($SQL);
		if ($rs && !$rs->EOF) {
			$res = $rs->fields;
			$rs->Close();
		}
		return $res;
	}
}

// Get result in HTML table
// options: fieldcaption(bool|array), horizontal(bool), tablename(string|array), tableclass(string)

if (!function_exists('ew_ExecuteHtml')) {

	// Get result in HTML table
	function ew_ExecuteHtml($SQL, $options = NULL) {
		$TableClass = "table table-bordered table-striped ewDbTable"; // Table CSS class name
		$ar = is_array($options) ? $options : array();
		$horizontal = (array_key_exists("horizontal", $ar) && $ar["horizontal"]);
		$rs = ew_LoadRecordset($SQL);
		if (!$rs || $rs->EOF || $rs->FieldCount() < 1)
			return "";
		$html = "";
		$class = (array_key_exists("tableclass", $ar) && $ar["tableclass"]) ? $ar["tableclass"] : $TableClass;
		if ($rs->RecordCount() > 1 || $horizontal) { // Horizontal table
			$cnt = $rs->FieldCount();
			$html = "<table class=\"" . $class . "\">";
			$html .= "<thead><tr>";
			$row = &$rs->fields;
			foreach ($row as $key => $value) {
				if (!is_numeric($key))
					$html .= "<th>" . ew_GetFieldCaption($key, $ar) . "</th>";
			}
			$html .= "</tr></thead>";
			$html .= "<tbody>";
			$rowcnt = 0;
			while (!$rs->EOF) {
				$html .= "<tr>";
				$row = &$rs->fields;
				foreach ($row as $key => $value) {
					if (!is_numeric($key))
						$html .= "<td>" . $value . "</td>";
				}
				$html .= "</tr>";
				$rs->MoveNext();
			}
			$html .= "</tbody></table>";
		} else { // Single row, vertical table
			$html = "<table class=\"" . $class . "\"><tbody>";
			$row = &$rs->fields;
			foreach ($row as $key => $value) {
				if (!is_numeric($key)) {
					$html .= "<tr>";
					$html .= "<td>" . ew_GetFieldCaption($key, $ar) . "</td>";
					$html .= "<td>" . $value . "</td></tr>";
				}
			}
			$html .= "</tbody></table>";
		}
		return $html;
	}

	function ew_GetFieldCaption($key, $ar) {
		global $Language;
		$caption = "";
		if (!is_array($ar))
			return $key;
		$tablename = @$ar["tablename"];
		$usecaption = (array_key_exists("fieldcaption", $ar) && $ar["fieldcaption"]);
		if ($usecaption) {
			if (is_array($ar["fieldcaption"])) {
				$caption = @$ar["fieldcaption"][$key];
			} elseif (isset($Language)) {
				if (is_array($tablename)) {
					foreach ($tablename as $tbl) {
						$caption = @$Language->FieldPhrase($tbl, $key, "FldCaption");
						if ($caption <> "")
							break;
					}
				} elseif ($tablename <> "") {
					$caption = @$Language->FieldPhrase($tablename, $key, "FldCaption");
				}
			}
		}
		return ($caption <> "") ? $caption : $key;
	}
}

// Load recordset
if (!function_exists('ew_LoadRecordset')) {

	function &ew_LoadRecordset($SQL) {
		global $conn;
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($SQL);
		$conn->raiseErrorFn = '';
		return $rs;
	}
}

// Prepend CSS class name
function ew_PrependClass(&$attr, $classname) {
	$classname = trim($classname);
	if ($classname <> "") {
		$attr = trim($attr);
		if ($attr <> "")
			$attr = " " . $attr;
		$attr = $classname . $attr;
	}
}

// Append CSS class name
function ew_AppendClass(&$attr, $classname) {
	$classname = trim($classname);
	if ($classname <> "") {
		$attr = trim($attr);
		if ($attr <> "")
			$attr .= " ";
		$attr .= $classname;
	}
}

// Get numeric formatting information
function ew_LocaleConv() {
	$info = defined("EW_DEFAULT_LOCALE") ? json_decode(EW_DEFAULT_LOCALE, TRUE) : NULL;
	return ($info) ? $info : localeconv();
}

// Get path relative to a base path
function ew_PathCombine($BasePath, $RelPath, $PhyPath) {
	if (preg_match('/^(http|ftp)s?\:\/\//i', $RelPath)) // Allow remote file
		return $RelPath;
	$BasePath = ew_RemoveTrailingDelimiter($BasePath, $PhyPath);
	if ($PhyPath) {
		$Delimiter = EW_PATH_DELIMITER;
		$RelPath = str_replace(array('/', '\\'), EW_PATH_DELIMITER, $RelPath);
	} else {
		$Delimiter = '/';
		$RelPath = str_replace('\\', '/', $RelPath);
	}
	$RelPath = ew_IncludeTrailingDelimiter($RelPath, $PhyPath);
	$p1 = strpos($RelPath, $Delimiter);
	$Path2 = "";
	while ($p1 !== FALSE) {
		$Path = substr($RelPath, 0, $p1 + 1);
		if ($Path == $Delimiter || $Path == '.' . $Delimiter) {

			// Skip
		} elseif ($Path == '..' . $Delimiter) {
			$p2 = strrpos($BasePath, $Delimiter);
			if ($p2 === 0) { // BasePath = "/xxx", cannot move up
				$BasePath = $Delimiter;
			} elseif ($p2 !== FALSE && substr($BasePath, -2) <> "..")
				$BasePath = substr($BasePath, 0, $p2);
			elseif ($BasePath <> "" && $BasePath <> "..")
				$BasePath = "";
			else
				$Path2 .= ".." . $Delimiter;
		} else {
			$Path2 .= $Path;
		}
		$RelPath = substr($RelPath, $p1+1);
		if ($RelPath === FALSE)
			$RelPath = "";
		$p1 = strpos($RelPath, $Delimiter);
	}
	return (($BasePath === "") ? "" : ew_IncludeTrailingDelimiter($BasePath, $PhyPath)) . $Path2 . $RelPath;
}

// Remove the last delimiter for a path
function ew_RemoveTrailingDelimiter($Path, $PhyPath) {
	$Delimiter = ($PhyPath) ? EW_PATH_DELIMITER : '/';
	while (substr($Path, -1) == $Delimiter)
		$Path = substr($Path, 0, strlen($Path)-1);
	return $Path;
}

// Include the last delimiter for a path
function ew_IncludeTrailingDelimiter($Path, $PhyPath) {
	$Path = ew_RemoveTrailingDelimiter($Path, $PhyPath);
	$Delimiter = ($PhyPath) ? EW_PATH_DELIMITER : '/';
	return $Path . $Delimiter;
}
?>
