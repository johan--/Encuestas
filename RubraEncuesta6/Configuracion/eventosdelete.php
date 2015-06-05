<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg11.php" ?>
<?php include_once "ewmysql11.php" ?>
<?php include_once "phpfn11.php" ?>
<?php include_once "eventosinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn11.php" ?>
<?php

//
// Page class
//

$eventos_delete = NULL; // Initialize page object first

class ceventos_delete extends ceventos {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{ADE930FF-1B1F-40A3-B075-C7C26BDE4A4A}";

	// Table name
	var $TableName = 'eventos';

	// Page object name
	var $PageObjName = 'eventos_delete';

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

		// Table object (eventos)
		if (!isset($GLOBALS["eventos"]) || get_class($GLOBALS["eventos"]) == "ceventos") {
			$GLOBALS["eventos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["eventos"];
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
			define("EW_TABLE_NAME", 'eventos', TRUE);

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
		global $EW_EXPORT, $eventos;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($eventos);
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
			$this->Page_Terminate("eventoslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in eventos class, eventosinfo.php

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
		$this->Id->setDbValue($rs->fields('Id'));
		$this->Nombre->setDbValue($rs->fields('Nombre'));
		$this->idCliente->setDbValue($rs->fields('idCliente'));
		$this->Descripcion->setDbValue($rs->fields('Descripcion'));
		$this->FechaInicio->setDbValue($rs->fields('FechaInicio'));
		$this->FechaFin->setDbValue($rs->fields('FechaFin'));
		$this->Estado->setDbValue($rs->fields('Estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id->DbValue = $row['Id'];
		$this->Nombre->DbValue = $row['Nombre'];
		$this->idCliente->DbValue = $row['idCliente'];
		$this->Descripcion->DbValue = $row['Descripcion'];
		$this->FechaInicio->DbValue = $row['FechaInicio'];
		$this->FechaFin->DbValue = $row['FechaFin'];
		$this->Estado->DbValue = $row['Estado'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id
		// Nombre
		// idCliente
		// Descripcion
		// FechaInicio
		// FechaFin
		// Estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Nombre
			$this->Nombre->ViewValue = $this->Nombre->CurrentValue;
			$this->Nombre->ViewCustomAttributes = "";

			// idCliente
			if (strval($this->idCliente->CurrentValue) <> "") {
				$sFilterWrk = "`Id`" . ew_SearchString("=", $this->idCliente->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clientes`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Estado`= 'A'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idCliente, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocial` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idCliente->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idCliente->ViewValue = $this->idCliente->CurrentValue;
				}
			} else {
				$this->idCliente->ViewValue = NULL;
			}
			$this->idCliente->ViewCustomAttributes = "";

			// Descripcion
			$this->Descripcion->ViewValue = $this->Descripcion->CurrentValue;
			$this->Descripcion->ViewCustomAttributes = "";

			// FechaInicio
			$this->FechaInicio->ViewValue = $this->FechaInicio->CurrentValue;
			$this->FechaInicio->ViewValue = ew_FormatDateTime($this->FechaInicio->ViewValue, 7);
			$this->FechaInicio->ViewCustomAttributes = "";

			// FechaFin
			$this->FechaFin->ViewValue = $this->FechaFin->CurrentValue;
			$this->FechaFin->ViewValue = ew_FormatDateTime($this->FechaFin->ViewValue, 7);
			$this->FechaFin->ViewCustomAttributes = "";

			// Estado
			if (strval($this->Estado->CurrentValue) <> "") {
				switch ($this->Estado->CurrentValue) {
					case $this->Estado->FldTagValue(1):
						$this->Estado->ViewValue = $this->Estado->FldTagCaption(1) <> "" ? $this->Estado->FldTagCaption(1) : $this->Estado->CurrentValue;
						break;
					case $this->Estado->FldTagValue(2):
						$this->Estado->ViewValue = $this->Estado->FldTagCaption(2) <> "" ? $this->Estado->FldTagCaption(2) : $this->Estado->CurrentValue;
						break;
					default:
						$this->Estado->ViewValue = $this->Estado->CurrentValue;
				}
			} else {
				$this->Estado->ViewValue = NULL;
			}
			$this->Estado->ViewCustomAttributes = "";

			// Nombre
			$this->Nombre->LinkCustomAttributes = "";
			$this->Nombre->HrefValue = "";
			$this->Nombre->TooltipValue = "";

			// idCliente
			$this->idCliente->LinkCustomAttributes = "";
			$this->idCliente->HrefValue = "";
			$this->idCliente->TooltipValue = "";

			// Descripcion
			$this->Descripcion->LinkCustomAttributes = "";
			$this->Descripcion->HrefValue = "";
			$this->Descripcion->TooltipValue = "";

			// FechaInicio
			$this->FechaInicio->LinkCustomAttributes = "";
			$this->FechaInicio->HrefValue = "";
			$this->FechaInicio->TooltipValue = "";

			// FechaFin
			$this->FechaFin->LinkCustomAttributes = "";
			$this->FechaFin->HrefValue = "";
			$this->FechaFin->TooltipValue = "";

			// Estado
			$this->Estado->LinkCustomAttributes = "";
			$this->Estado->HrefValue = "";
			$this->Estado->TooltipValue = "";
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
				$sThisKey .= $row['Id'];
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
		$Breadcrumb->Add("list", $this->TableVar, "eventoslist.php", "", $this->TableVar, TRUE);
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
if (!isset($eventos_delete)) $eventos_delete = new ceventos_delete();

// Page init
$eventos_delete->Page_Init();

// Page main
$eventos_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$eventos_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var eventos_delete = new ew_Page("eventos_delete");
eventos_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = eventos_delete.PageID; // For backward compatibility

// Form object
var feventosdelete = new ew_Form("feventosdelete");

// Form_CustomValidate event
feventosdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
feventosdelete.ValidateRequired = true;
<?php } else { ?>
feventosdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
feventosdelete.Lists["x_idCliente"] = {"LinkField":"x_Id","Ajax":true,"AutoFill":false,"DisplayFields":["x_RazonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($eventos_delete->Recordset = $eventos_delete->LoadRecordset())
	$eventos_deleteTotalRecs = $eventos_delete->Recordset->RecordCount(); // Get record count
if ($eventos_deleteTotalRecs <= 0) { // No record found, exit
	if ($eventos_delete->Recordset)
		$eventos_delete->Recordset->Close();
	$eventos_delete->Page_Terminate("eventoslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $eventos_delete->ShowPageHeader(); ?>
<?php
$eventos_delete->ShowMessage();
?>
<form name="feventosdelete" id="feventosdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($eventos_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $eventos_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="eventos">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($eventos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $eventos->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($eventos->Nombre->Visible) { // Nombre ?>
		<th><span id="elh_eventos_Nombre" class="eventos_Nombre"><?php echo $eventos->Nombre->FldCaption() ?></span></th>
<?php } ?>
<?php if ($eventos->idCliente->Visible) { // idCliente ?>
		<th><span id="elh_eventos_idCliente" class="eventos_idCliente"><?php echo $eventos->idCliente->FldCaption() ?></span></th>
<?php } ?>
<?php if ($eventos->Descripcion->Visible) { // Descripcion ?>
		<th><span id="elh_eventos_Descripcion" class="eventos_Descripcion"><?php echo $eventos->Descripcion->FldCaption() ?></span></th>
<?php } ?>
<?php if ($eventos->FechaInicio->Visible) { // FechaInicio ?>
		<th><span id="elh_eventos_FechaInicio" class="eventos_FechaInicio"><?php echo $eventos->FechaInicio->FldCaption() ?></span></th>
<?php } ?>
<?php if ($eventos->FechaFin->Visible) { // FechaFin ?>
		<th><span id="elh_eventos_FechaFin" class="eventos_FechaFin"><?php echo $eventos->FechaFin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($eventos->Estado->Visible) { // Estado ?>
		<th><span id="elh_eventos_Estado" class="eventos_Estado"><?php echo $eventos->Estado->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$eventos_delete->RecCnt = 0;
$i = 0;
while (!$eventos_delete->Recordset->EOF) {
	$eventos_delete->RecCnt++;
	$eventos_delete->RowCnt++;

	// Set row properties
	$eventos->ResetAttrs();
	$eventos->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$eventos_delete->LoadRowValues($eventos_delete->Recordset);

	// Render row
	$eventos_delete->RenderRow();
?>
	<tr<?php echo $eventos->RowAttributes() ?>>
<?php if ($eventos->Nombre->Visible) { // Nombre ?>
		<td<?php echo $eventos->Nombre->CellAttributes() ?>>
<span id="el<?php echo $eventos_delete->RowCnt ?>_eventos_Nombre" class="form-group eventos_Nombre">
<span<?php echo $eventos->Nombre->ViewAttributes() ?>>
<?php echo $eventos->Nombre->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($eventos->idCliente->Visible) { // idCliente ?>
		<td<?php echo $eventos->idCliente->CellAttributes() ?>>
<span id="el<?php echo $eventos_delete->RowCnt ?>_eventos_idCliente" class="form-group eventos_idCliente">
<span<?php echo $eventos->idCliente->ViewAttributes() ?>>
<?php echo $eventos->idCliente->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($eventos->Descripcion->Visible) { // Descripcion ?>
		<td<?php echo $eventos->Descripcion->CellAttributes() ?>>
<span id="el<?php echo $eventos_delete->RowCnt ?>_eventos_Descripcion" class="form-group eventos_Descripcion">
<span<?php echo $eventos->Descripcion->ViewAttributes() ?>>
<?php echo $eventos->Descripcion->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($eventos->FechaInicio->Visible) { // FechaInicio ?>
		<td<?php echo $eventos->FechaInicio->CellAttributes() ?>>
<span id="el<?php echo $eventos_delete->RowCnt ?>_eventos_FechaInicio" class="form-group eventos_FechaInicio">
<span<?php echo $eventos->FechaInicio->ViewAttributes() ?>>
<?php echo $eventos->FechaInicio->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($eventos->FechaFin->Visible) { // FechaFin ?>
		<td<?php echo $eventos->FechaFin->CellAttributes() ?>>
<span id="el<?php echo $eventos_delete->RowCnt ?>_eventos_FechaFin" class="form-group eventos_FechaFin">
<span<?php echo $eventos->FechaFin->ViewAttributes() ?>>
<?php echo $eventos->FechaFin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($eventos->Estado->Visible) { // Estado ?>
		<td<?php echo $eventos->Estado->CellAttributes() ?>>
<span id="el<?php echo $eventos_delete->RowCnt ?>_eventos_Estado" class="form-group eventos_Estado">
<span<?php echo $eventos->Estado->ViewAttributes() ?>>
<?php echo $eventos->Estado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$eventos_delete->Recordset->MoveNext();
}
$eventos_delete->Recordset->Close();
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
feventosdelete.Init();
</script>
<?php
$eventos_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$eventos_delete->Page_Terminate();
?>
