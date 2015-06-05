<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg11.php" ?>
<?php include_once "ewmysql11.php" ?>
<?php include_once "phpfn11.php" ?>
<?php include_once "encuestasinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn11.php" ?>
<?php

//
// Page class
//

$encuestas_delete = NULL; // Initialize page object first

class cencuestas_delete extends cencuestas {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{ADE930FF-1B1F-40A3-B075-C7C26BDE4A4A}";

	// Table name
	var $TableName = 'encuestas';

	// Page object name
	var $PageObjName = 'encuestas_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (encuestas)
		if (!isset($GLOBALS["encuestas"]) || get_class($GLOBALS["encuestas"]) == "cencuestas") {
			$GLOBALS["encuestas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["encuestas"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// User table object (usuarios)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'encuestas', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn, $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $encuestas;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($encuestas);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("encuestaslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in encuestas class, encuestasinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Load List page SQL
		$sSql = $this->SelectSQL();

		// Load recordset
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->idEvento->setDbValue($rs->fields('idEvento'));
		$this->objetivo->setDbValue($rs->fields('objetivo'));
		$this->fechaInicio->setDbValue($rs->fields('fechaInicio'));
		$this->fechaFin->setDbValue($rs->fields('fechaFin'));
		$this->logo_encuesta->Upload->DbValue = $rs->fields('logo_encuesta');
		if (is_array($this->logo_encuesta->Upload->DbValue) || is_object($this->logo_encuesta->Upload->DbValue)) // Byte array
			$this->logo_encuesta->Upload->DbValue = ew_BytesToStr($this->logo_encuesta->Upload->DbValue);
		$this->rtaMultiple->setDbValue($rs->fields('rtaMultiple'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->idEvento->DbValue = $row['idEvento'];
		$this->objetivo->DbValue = $row['objetivo'];
		$this->fechaInicio->DbValue = $row['fechaInicio'];
		$this->fechaFin->DbValue = $row['fechaFin'];
		$this->logo_encuesta->Upload->DbValue = $row['logo_encuesta'];
		$this->rtaMultiple->DbValue = $row['rtaMultiple'];
		$this->estado->DbValue = $row['estado'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// idEvento
		// objetivo
		// fechaInicio
		// fechaFin
		// logo_encuesta
		// rtaMultiple
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// rtaMultiple
			$this->rtaMultiple->LinkCustomAttributes = "";
			$this->rtaMultiple->HrefValue = "";
			$this->rtaMultiple->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$this->LoadDbValues($row);
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "encuestaslist.php", "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($encuestas_delete)) $encuestas_delete = new cencuestas_delete();

// Page init
$encuestas_delete->Page_Init();

// Page main
$encuestas_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$encuestas_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var encuestas_delete = new ew_Page("encuestas_delete");
encuestas_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = encuestas_delete.PageID; // For backward compatibility

// Form object
var fencuestasdelete = new ew_Form("fencuestasdelete");

// Form_CustomValidate event
fencuestasdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fencuestasdelete.ValidateRequired = true;
<?php } else { ?>
fencuestasdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fencuestasdelete.Lists["x_idEvento"] = {"LinkField":"x_Id","Ajax":null,"AutoFill":false,"DisplayFields":["x_Nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($encuestas_delete->Recordset = $encuestas_delete->LoadRecordset())
	$encuestas_deleteTotalRecs = $encuestas_delete->Recordset->RecordCount(); // Get record count
if ($encuestas_deleteTotalRecs <= 0) { // No record found, exit
	if ($encuestas_delete->Recordset)
		$encuestas_delete->Recordset->Close();
	$encuestas_delete->Page_Terminate("encuestaslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $encuestas_delete->ShowPageHeader(); ?>
<?php
$encuestas_delete->ShowMessage();
?>
<form name="fencuestasdelete" id="fencuestasdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($encuestas_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $encuestas_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="encuestas">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($encuestas_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $encuestas->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($encuestas->idEvento->Visible) { // idEvento ?>
		<th><span id="elh_encuestas_idEvento" class="encuestas_idEvento"><?php echo $encuestas->idEvento->FldCaption() ?></span></th>
<?php } ?>
<?php if ($encuestas->objetivo->Visible) { // objetivo ?>
		<th><span id="elh_encuestas_objetivo" class="encuestas_objetivo"><?php echo $encuestas->objetivo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($encuestas->fechaInicio->Visible) { // fechaInicio ?>
		<th><span id="elh_encuestas_fechaInicio" class="encuestas_fechaInicio"><?php echo $encuestas->fechaInicio->FldCaption() ?></span></th>
<?php } ?>
<?php if ($encuestas->fechaFin->Visible) { // fechaFin ?>
		<th><span id="elh_encuestas_fechaFin" class="encuestas_fechaFin"><?php echo $encuestas->fechaFin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($encuestas->rtaMultiple->Visible) { // rtaMultiple ?>
		<th><span id="elh_encuestas_rtaMultiple" class="encuestas_rtaMultiple"><?php echo $encuestas->rtaMultiple->FldCaption() ?></span></th>
<?php } ?>
<?php if ($encuestas->estado->Visible) { // estado ?>
		<th><span id="elh_encuestas_estado" class="encuestas_estado"><?php echo $encuestas->estado->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$encuestas_delete->RecCnt = 0;
$i = 0;
while (!$encuestas_delete->Recordset->EOF) {
	$encuestas_delete->RecCnt++;
	$encuestas_delete->RowCnt++;

	// Set row properties
	$encuestas->ResetAttrs();
	$encuestas->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$encuestas_delete->LoadRowValues($encuestas_delete->Recordset);

	// Render row
	$encuestas_delete->RenderRow();
?>
	<tr<?php echo $encuestas->RowAttributes() ?>>
<?php if ($encuestas->idEvento->Visible) { // idEvento ?>
		<td<?php echo $encuestas->idEvento->CellAttributes() ?>>
<span id="el<?php echo $encuestas_delete->RowCnt ?>_encuestas_idEvento" class="form-group encuestas_idEvento">
<span<?php echo $encuestas->idEvento->ViewAttributes() ?>>
<?php echo $encuestas->idEvento->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($encuestas->objetivo->Visible) { // objetivo ?>
		<td<?php echo $encuestas->objetivo->CellAttributes() ?>>
<span id="el<?php echo $encuestas_delete->RowCnt ?>_encuestas_objetivo" class="form-group encuestas_objetivo">
<span<?php echo $encuestas->objetivo->ViewAttributes() ?>>
<?php echo $encuestas->objetivo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($encuestas->fechaInicio->Visible) { // fechaInicio ?>
		<td<?php echo $encuestas->fechaInicio->CellAttributes() ?>>
<span id="el<?php echo $encuestas_delete->RowCnt ?>_encuestas_fechaInicio" class="form-group encuestas_fechaInicio">
<span<?php echo $encuestas->fechaInicio->ViewAttributes() ?>>
<?php echo $encuestas->fechaInicio->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($encuestas->fechaFin->Visible) { // fechaFin ?>
		<td<?php echo $encuestas->fechaFin->CellAttributes() ?>>
<span id="el<?php echo $encuestas_delete->RowCnt ?>_encuestas_fechaFin" class="form-group encuestas_fechaFin">
<span<?php echo $encuestas->fechaFin->ViewAttributes() ?>>
<?php echo $encuestas->fechaFin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($encuestas->rtaMultiple->Visible) { // rtaMultiple ?>
		<td<?php echo $encuestas->rtaMultiple->CellAttributes() ?>>
<span id="el<?php echo $encuestas_delete->RowCnt ?>_encuestas_rtaMultiple" class="form-group encuestas_rtaMultiple">
<span<?php echo $encuestas->rtaMultiple->ViewAttributes() ?>>
<?php echo $encuestas->rtaMultiple->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($encuestas->estado->Visible) { // estado ?>
		<td<?php echo $encuestas->estado->CellAttributes() ?>>
<span id="el<?php echo $encuestas_delete->RowCnt ?>_encuestas_estado" class="form-group encuestas_estado">
<span<?php echo $encuestas->estado->ViewAttributes() ?>>
<?php echo $encuestas->estado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$encuestas_delete->Recordset->MoveNext();
}
$encuestas_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fencuestasdelete.Init();
</script>
<?php
$encuestas_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$encuestas_delete->Page_Terminate();
?>
