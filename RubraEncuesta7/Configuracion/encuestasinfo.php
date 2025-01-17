<?php

// Global variable for table object
$encuestas = NULL;

//
// Table class for encuestas
//
class cencuestas extends cTable {
	var $id;
	var $idEvento;
	var $objetivo;
	var $fechaInicio;
	var $fechaFin;
	var $logo_encuesta;
	var $rtaMultiple;
	var $estado;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'encuestas';
		$this->TableName = 'encuestas';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('encuestas', 'encuestas', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// idEvento
		$this->idEvento = new cField('encuestas', 'encuestas', 'x_idEvento', 'idEvento', '`idEvento`', '`idEvento`', 3, -1, FALSE, '`idEvento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idEvento->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idEvento'] = &$this->idEvento;

		// objetivo
		$this->objetivo = new cField('encuestas', 'encuestas', 'x_objetivo', 'objetivo', '`objetivo`', '`objetivo`', 200, -1, FALSE, '`objetivo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['objetivo'] = &$this->objetivo;

		// fechaInicio
		$this->fechaInicio = new cField('encuestas', 'encuestas', 'x_fechaInicio', 'fechaInicio', '`fechaInicio`', 'DATE_FORMAT(`fechaInicio`, \'%d/%m/%Y\')', 133, 7, FALSE, '`fechaInicio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fechaInicio->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fechaInicio'] = &$this->fechaInicio;

		// fechaFin
		$this->fechaFin = new cField('encuestas', 'encuestas', 'x_fechaFin', 'fechaFin', '`fechaFin`', 'DATE_FORMAT(`fechaFin`, \'%d/%m/%Y\')', 133, 7, FALSE, '`fechaFin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fechaFin->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fechaFin'] = &$this->fechaFin;

		// logo_encuesta
		$this->logo_encuesta = new cField('encuestas', 'encuestas', 'x_logo_encuesta', 'logo_encuesta', '`logo_encuesta`', '`logo_encuesta`', 205, -1, TRUE, '`logo_encuesta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['logo_encuesta'] = &$this->logo_encuesta;

		// rtaMultiple
		$this->rtaMultiple = new cField('encuestas', 'encuestas', 'x_rtaMultiple', 'rtaMultiple', '`rtaMultiple`', '`rtaMultiple`', 200, -1, FALSE, '`rtaMultiple`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['rtaMultiple'] = &$this->rtaMultiple;

		// estado
		$this->estado = new cField('encuestas', 'encuestas', 'x_estado', 'estado', '`estado`', '`estado`', 200, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`encuestas`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`estado` ASC,`id` ASC";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`encuestas`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL) {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id') . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType));
		}
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "encuestaslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "encuestaslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("encuestasview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("encuestasview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "encuestasadd.php?" . $this->UrlParm($parm);
		else
			return "encuestasadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("encuestasedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("encuestasadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("encuestasdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["id"]; // id

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->idEvento->setDbValue($rs->fields('idEvento'));
		$this->objetivo->setDbValue($rs->fields('objetivo'));
		$this->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$this->fechaFin->setDbValue($rs->fields('fechaFin'));
		$this->logo_encuesta->Upload->DbValue = $rs->fields('logo_encuesta');
		$this->rtaMultiple->setDbValue($rs->fields('rtaMultiple'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// idEvento
		// objetivo
		// fechaInicio
		// fechaFin
		// logo_encuesta
		// rtaMultiple
		// estado
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// idEvento
		if (strval($this->idEvento->CurrentValue) <> "") {
			$sFilterWrk = "`Id`" . ew_SearchString("=", $this->idEvento->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `eventos`";
		$sWhereWrk = "";
		$lookuptblfilter = "`Estado` like `A`";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idEvento, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nombre` DESC";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idEvento->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idEvento->ViewValue = $this->idEvento->CurrentValue;
			}
		} else {
			$this->idEvento->ViewValue = NULL;
		}
		$this->idEvento->ViewCustomAttributes = "";

		// objetivo
		$this->objetivo->ViewValue = $this->objetivo->CurrentValue;
		$this->objetivo->ViewCustomAttributes = "";

		// fechaInicio
		$this->fechaInicio->ViewValue = $this->fechaInicio->CurrentValue;
		$this->fechaInicio->ViewValue = ew_FormatDateTime($this->fechaInicio->ViewValue, 7);
		$this->fechaInicio->ViewCustomAttributes = "";

		// fechaFin
		$this->fechaFin->ViewValue = $this->fechaFin->CurrentValue;
		$this->fechaFin->ViewValue = ew_FormatDateTime($this->fechaFin->ViewValue, 7);
		$this->fechaFin->ViewCustomAttributes = "";

		// logo_encuesta
		if (!ew_Empty($this->logo_encuesta->Upload->DbValue)) {
			$this->logo_encuesta->ViewValue = $this->logo_encuesta->FldCaption();
		} else {
			$this->logo_encuesta->ViewValue = "";
		}
		$this->logo_encuesta->ViewCustomAttributes = "";

		// rtaMultiple
		if (strval($this->rtaMultiple->CurrentValue) <> "") {
			switch ($this->rtaMultiple->CurrentValue) {
				case $this->rtaMultiple->FldTagValue(1):
					$this->rtaMultiple->ViewValue = $this->rtaMultiple->FldTagCaption(1) <> "" ? $this->rtaMultiple->FldTagCaption(1) : $this->rtaMultiple->CurrentValue;
					break;
				case $this->rtaMultiple->FldTagValue(2):
					$this->rtaMultiple->ViewValue = $this->rtaMultiple->FldTagCaption(2) <> "" ? $this->rtaMultiple->FldTagCaption(2) : $this->rtaMultiple->CurrentValue;
					break;
				default:
					$this->rtaMultiple->ViewValue = $this->rtaMultiple->CurrentValue;
			}
		} else {
			$this->rtaMultiple->ViewValue = NULL;
		}
		$this->rtaMultiple->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			switch ($this->estado->CurrentValue) {
				case $this->estado->FldTagValue(1):
					$this->estado->ViewValue = $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->CurrentValue;
					break;
				case $this->estado->FldTagValue(2):
					$this->estado->ViewValue = $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->CurrentValue;
					break;
				default:
					$this->estado->ViewValue = $this->estado->CurrentValue;
			}
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// idEvento
		$this->idEvento->LinkCustomAttributes = "";
		$this->idEvento->HrefValue = "";
		$this->idEvento->TooltipValue = "";

		// objetivo
		$this->objetivo->LinkCustomAttributes = "";
		$this->objetivo->HrefValue = "";
		$this->objetivo->TooltipValue = "";

		// fechaInicio
		$this->fechaInicio->LinkCustomAttributes = "";
		$this->fechaInicio->HrefValue = "";
		$this->fechaInicio->TooltipValue = "";

		// fechaFin
		$this->fechaFin->LinkCustomAttributes = "";
		$this->fechaFin->HrefValue = "";
		$this->fechaFin->TooltipValue = "";

		// logo_encuesta
		$this->logo_encuesta->LinkCustomAttributes = "";
		if (!empty($this->logo_encuesta->Upload->DbValue)) {
			$this->logo_encuesta->HrefValue = "encuestas_logo_encuesta_bv.php?id=" . $this->id->CurrentValue;
			$this->logo_encuesta->LinkAttrs["target"] = "_blank";
			if ($this->Export <> "") $this->logo_encuesta->HrefValue = ew_ConvertFullUrl($this->logo_encuesta->HrefValue);
		} else {
			$this->logo_encuesta->HrefValue = "";
		}
		$this->logo_encuesta->HrefValue2 = "encuestas_logo_encuesta_bv.php?id=" . $this->id->CurrentValue;
		$this->logo_encuesta->TooltipValue = "";

		// rtaMultiple
		$this->rtaMultiple->LinkCustomAttributes = "";
		$this->rtaMultiple->HrefValue = "";
		$this->rtaMultiple->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// idEvento
		$this->idEvento->EditAttrs["class"] = "form-control";
		$this->idEvento->EditCustomAttributes = "";

		// objetivo
		$this->objetivo->EditAttrs["class"] = "form-control";
		$this->objetivo->EditCustomAttributes = "";
		$this->objetivo->EditValue = ew_HtmlEncode($this->objetivo->CurrentValue);
		$this->objetivo->PlaceHolder = ew_RemoveHtml($this->objetivo->FldCaption());

		// fechaInicio
		$this->fechaInicio->EditAttrs["class"] = "form-control";
		$this->fechaInicio->EditCustomAttributes = "";
		$this->fechaInicio->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fechaInicio->CurrentValue, 7));
		$this->fechaInicio->PlaceHolder = ew_RemoveHtml($this->fechaInicio->FldCaption());

		// fechaFin
		$this->fechaFin->EditAttrs["class"] = "form-control";
		$this->fechaFin->EditCustomAttributes = "";
		$this->fechaFin->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fechaFin->CurrentValue, 7));
		$this->fechaFin->PlaceHolder = ew_RemoveHtml($this->fechaFin->FldCaption());

		// logo_encuesta
		$this->logo_encuesta->EditAttrs["class"] = "form-control";
		$this->logo_encuesta->EditCustomAttributes = "";
		if (!ew_Empty($this->logo_encuesta->Upload->DbValue)) {
			$this->logo_encuesta->EditValue = $this->logo_encuesta->FldCaption();
		} else {
			$this->logo_encuesta->EditValue = "";
		}

		// rtaMultiple
		$this->rtaMultiple->EditAttrs["class"] = "form-control";
		$this->rtaMultiple->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->rtaMultiple->FldTagValue(1), $this->rtaMultiple->FldTagCaption(1) <> "" ? $this->rtaMultiple->FldTagCaption(1) : $this->rtaMultiple->FldTagValue(1));
		$arwrk[] = array($this->rtaMultiple->FldTagValue(2), $this->rtaMultiple->FldTagCaption(2) <> "" ? $this->rtaMultiple->FldTagCaption(2) : $this->rtaMultiple->FldTagValue(2));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->rtaMultiple->EditValue = $arwrk;

		// estado
		$this->estado->EditAttrs["class"] = "form-control";
		$this->estado->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
		$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->estado->EditValue = $arwrk;

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->idEvento->Exportable) $Doc->ExportCaption($this->idEvento);
					if ($this->objetivo->Exportable) $Doc->ExportCaption($this->objetivo);
					if ($this->fechaInicio->Exportable) $Doc->ExportCaption($this->fechaInicio);
					if ($this->fechaFin->Exportable) $Doc->ExportCaption($this->fechaFin);
					if ($this->logo_encuesta->Exportable) $Doc->ExportCaption($this->logo_encuesta);
					if ($this->rtaMultiple->Exportable) $Doc->ExportCaption($this->rtaMultiple);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->idEvento->Exportable) $Doc->ExportCaption($this->idEvento);
					if ($this->objetivo->Exportable) $Doc->ExportCaption($this->objetivo);
					if ($this->fechaInicio->Exportable) $Doc->ExportCaption($this->fechaInicio);
					if ($this->fechaFin->Exportable) $Doc->ExportCaption($this->fechaFin);
					if ($this->rtaMultiple->Exportable) $Doc->ExportCaption($this->rtaMultiple);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->idEvento->Exportable) $Doc->ExportField($this->idEvento);
						if ($this->objetivo->Exportable) $Doc->ExportField($this->objetivo);
						if ($this->fechaInicio->Exportable) $Doc->ExportField($this->fechaInicio);
						if ($this->fechaFin->Exportable) $Doc->ExportField($this->fechaFin);
						if ($this->logo_encuesta->Exportable) $Doc->ExportField($this->logo_encuesta);
						if ($this->rtaMultiple->Exportable) $Doc->ExportField($this->rtaMultiple);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->idEvento->Exportable) $Doc->ExportField($this->idEvento);
						if ($this->objetivo->Exportable) $Doc->ExportField($this->objetivo);
						if ($this->fechaInicio->Exportable) $Doc->ExportField($this->fechaInicio);
						if ($this->fechaFin->Exportable) $Doc->ExportField($this->fechaFin);
						if ($this->rtaMultiple->Exportable) $Doc->ExportField($this->rtaMultiple);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
