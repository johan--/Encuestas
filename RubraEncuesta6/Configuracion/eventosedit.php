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

$eventos_edit = NULL; // Initialize page object first

class ceventos_edit extends ceventos {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{ADE930FF-1B1F-40A3-B075-C7C26BDE4A4A}";

	// Table name
	var $TableName = 'eventos';

	// Page object name
	var $PageObjName = 'eventos_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $HashValue; // Hash Value
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["Id"] <> "") {
			$this->Id->setQueryStringValue($_GET["Id"]);
			$this->RecKey["Id"] = $this->Id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("eventoslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->Id->CurrentValue) == strval($this->Recordset->fields('Id'))) {
					$this->setStartRecordNumber($this->StartRec); // Save record position
					$bMatchRecord = TRUE;
					break;
				} else {
					$this->StartRec++;
					$this->Recordset->MoveNext();
				}
			}
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Overwrite record, reload hash value
			if ($this->CurrentAction == "overwrite") {
				$this->LoadRowHash();
				$this->CurrentAction = "F";
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("eventoslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
					$this->HashValue = $this->GetRowHash($this->Recordset); // Get hash value for record
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render as View
		} else {
			$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		}
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Nombre->FldIsDetailKey) {
			$this->Nombre->setFormValue($objForm->GetValue("x_Nombre"));
		}
		if (!$this->idCliente->FldIsDetailKey) {
			$this->idCliente->setFormValue($objForm->GetValue("x_idCliente"));
		}
		if (!$this->Descripcion->FldIsDetailKey) {
			$this->Descripcion->setFormValue($objForm->GetValue("x_Descripcion"));
		}
		if (!$this->FechaInicio->FldIsDetailKey) {
			$this->FechaInicio->setFormValue($objForm->GetValue("x_FechaInicio"));
			$this->FechaInicio->CurrentValue = ew_UnFormatDateTime($this->FechaInicio->CurrentValue, 7);
		}
		if (!$this->FechaFin->FldIsDetailKey) {
			$this->FechaFin->setFormValue($objForm->GetValue("x_FechaFin"));
			$this->FechaFin->CurrentValue = ew_UnFormatDateTime($this->FechaFin->CurrentValue, 7);
		}
		if (!$this->Estado->FldIsDetailKey) {
			$this->Estado->setFormValue($objForm->GetValue("x_Estado"));
		}
		if (!$this->Id->FldIsDetailKey)
			$this->Id->setFormValue($objForm->GetValue("x_Id"));
		if ($this->CurrentAction <> "overwrite")
			$this->HashValue = $objForm->GetValue("k_hash");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id->CurrentValue = $this->Id->FormValue;
		$this->Nombre->CurrentValue = $this->Nombre->FormValue;
		$this->idCliente->CurrentValue = $this->idCliente->FormValue;
		$this->Descripcion->CurrentValue = $this->Descripcion->FormValue;
		$this->FechaInicio->CurrentValue = $this->FechaInicio->FormValue;
		$this->FechaInicio->CurrentValue = ew_UnFormatDateTime($this->FechaInicio->CurrentValue, 7);
		$this->FechaFin->CurrentValue = $this->FechaFin->FormValue;
		$this->FechaFin->CurrentValue = ew_UnFormatDateTime($this->FechaFin->CurrentValue, 7);
		$this->Estado->CurrentValue = $this->Estado->FormValue;
		if ($this->CurrentAction <> "overwrite")
			$this->HashValue = $objForm->GetValue("k_hash");
	}

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
			if (!$this->EventCancelled)
				$this->HashValue = $this->GetRowHash($rs); // Get hash value for record
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Nombre
			$this->Nombre->EditAttrs["class"] = "form-control";
			$this->Nombre->EditCustomAttributes = "";
			$this->Nombre->EditValue = ew_HtmlEncode($this->Nombre->CurrentValue);
			$this->Nombre->PlaceHolder = ew_RemoveHtml($this->Nombre->FldCaption());

			// idCliente
			$this->idCliente->EditAttrs["class"] = "form-control";
			$this->idCliente->EditCustomAttributes = "";
			if (trim(strval($this->idCliente->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id`" . ew_SearchString("=", $this->idCliente->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `Id`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `RazonSocial` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `clientes`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idCliente->EditValue = $arwrk;

			// Descripcion
			$this->Descripcion->EditAttrs["class"] = "form-control";
			$this->Descripcion->EditCustomAttributes = "";
			$this->Descripcion->EditValue = ew_HtmlEncode($this->Descripcion->CurrentValue);
			$this->Descripcion->PlaceHolder = ew_RemoveHtml($this->Descripcion->FldCaption());

			// FechaInicio
			$this->FechaInicio->EditAttrs["class"] = "form-control";
			$this->FechaInicio->EditCustomAttributes = "";
			$this->FechaInicio->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->FechaInicio->CurrentValue, 7));
			$this->FechaInicio->PlaceHolder = ew_RemoveHtml($this->FechaInicio->FldCaption());

			// FechaFin
			$this->FechaFin->EditAttrs["class"] = "form-control";
			$this->FechaFin->EditCustomAttributes = "";
			$this->FechaFin->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->FechaFin->CurrentValue, 7));
			$this->FechaFin->PlaceHolder = ew_RemoveHtml($this->FechaFin->FldCaption());

			// Estado
			$this->Estado->EditAttrs["class"] = "form-control";
			$this->Estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Estado->FldTagValue(1), $this->Estado->FldTagCaption(1) <> "" ? $this->Estado->FldTagCaption(1) : $this->Estado->FldTagValue(1));
			$arwrk[] = array($this->Estado->FldTagValue(2), $this->Estado->FldTagCaption(2) <> "" ? $this->Estado->FldTagCaption(2) : $this->Estado->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->Estado->EditValue = $arwrk;

			// Edit refer script
			// Nombre

			$this->Nombre->HrefValue = "";

			// idCliente
			$this->idCliente->HrefValue = "";

			// Descripcion
			$this->Descripcion->HrefValue = "";

			// FechaInicio
			$this->FechaInicio->HrefValue = "";

			// FechaFin
			$this->FechaFin->HrefValue = "";

			// Estado
			$this->Estado->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->Nombre->FldIsDetailKey && !is_null($this->Nombre->FormValue) && $this->Nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nombre->FldCaption(), $this->Nombre->ReqErrMsg));
		}
		if (!$this->idCliente->FldIsDetailKey && !is_null($this->idCliente->FormValue) && $this->idCliente->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idCliente->FldCaption(), $this->idCliente->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->FechaInicio->FormValue)) {
			ew_AddMessage($gsFormError, $this->FechaInicio->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->FechaFin->FormValue)) {
			ew_AddMessage($gsFormError, $this->FechaFin->FldErrMsg());
		}
		if (!$this->Estado->FldIsDetailKey && !is_null($this->Estado->FormValue) && $this->Estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado->FldCaption(), $this->Estado->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		if ($this->idCliente->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`idCliente` = " . ew_AdjustSql($this->idCliente->CurrentValue) . ")";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->idCliente->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->idCliente->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Nombre
			$this->Nombre->SetDbValueDef($rsnew, $this->Nombre->CurrentValue, "", $this->Nombre->ReadOnly);

			// idCliente
			$this->idCliente->SetDbValueDef($rsnew, $this->idCliente->CurrentValue, 0, $this->idCliente->ReadOnly);

			// Descripcion
			$this->Descripcion->SetDbValueDef($rsnew, $this->Descripcion->CurrentValue, NULL, $this->Descripcion->ReadOnly);

			// FechaInicio
			$this->FechaInicio->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->FechaInicio->CurrentValue, 7), NULL, $this->FechaInicio->ReadOnly);

			// FechaFin
			$this->FechaFin->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->FechaFin->CurrentValue, 7), NULL, $this->FechaFin->ReadOnly);

			// Estado
			$this->Estado->SetDbValueDef($rsnew, $this->Estado->CurrentValue, "", $this->Estado->ReadOnly);

			// Check hash value
			$bRowHasConflict = ($this->GetRowHash($rs) <> $this->HashValue);

			// Call Row Update Conflict event
			if ($bRowHasConflict)
				$bRowHasConflict = $this->Row_UpdateConflict($rsold, $rsnew);
			if ($bRowHasConflict) {
				$this->setFailureMessage($Language->Phrase("RecordChangedByOtherUser"));
				$this->UpdateConflict = "U";
				$rs->Close();
				return FALSE; // Update Failed
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Load row hash
	function LoadRowHash() {
		global $conn;
		$sFilter = $this->KeyFilter();

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$RsRow = $conn->Execute($sSql);
		$this->HashValue = ($RsRow && !$RsRow->EOF) ? $this->GetRowHash($RsRow) : ""; // Get hash value for record
		$RsRow->Close();
	}

	// Get Row Hash
	function GetRowHash(&$rs) {
		if (!$rs)
			return "";
		$sHash = "";
		$sHash .= ew_GetFldHash($rs->fields('Nombre')); // Nombre
		$sHash .= ew_GetFldHash($rs->fields('idCliente')); // idCliente
		$sHash .= ew_GetFldHash($rs->fields('Descripcion')); // Descripcion
		$sHash .= ew_GetFldHash($rs->fields('FechaInicio')); // FechaInicio
		$sHash .= ew_GetFldHash($rs->fields('FechaFin')); // FechaFin
		$sHash .= ew_GetFldHash($rs->fields('Estado')); // Estado
		return md5($sHash);
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "eventoslist.php", "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($eventos_edit)) $eventos_edit = new ceventos_edit();

// Page init
$eventos_edit->Page_Init();

// Page main
$eventos_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$eventos_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var eventos_edit = new ew_Page("eventos_edit");
eventos_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = eventos_edit.PageID; // For backward compatibility

// Form object
var feventosedit = new ew_Form("feventosedit");

// Validate form
feventosedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_Nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $eventos->Nombre->FldCaption(), $eventos->Nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idCliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $eventos->idCliente->FldCaption(), $eventos->idCliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_FechaInicio");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($eventos->FechaInicio->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_FechaFin");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($eventos->FechaFin->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $eventos->Estado->FldCaption(), $eventos->Estado->ReqErrMsg)) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
feventosedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
feventosedit.ValidateRequired = true;
<?php } else { ?>
feventosedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
feventosedit.Lists["x_idCliente"] = {"LinkField":"x_Id","Ajax":true,"AutoFill":false,"DisplayFields":["x_RazonSocial","","",""],"ParentFields":["x_idCliente"],"FilterFields":["x_RazonSocial"],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $eventos_edit->ShowPageHeader(); ?>
<?php
$eventos_edit->ShowMessage();
?>
<?php if ($eventos->CurrentAction <> "F") { // Confirm page ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($eventos_edit->Pager)) $eventos_edit->Pager = new cPrevNextPager($eventos_edit->StartRec, $eventos_edit->DisplayRecs, $eventos_edit->TotalRecs) ?>
<?php if ($eventos_edit->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($eventos_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $eventos_edit->PageUrl() ?>start=<?php echo $eventos_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($eventos_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $eventos_edit->PageUrl() ?>start=<?php echo $eventos_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $eventos_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($eventos_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $eventos_edit->PageUrl() ?>start=<?php echo $eventos_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($eventos_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $eventos_edit->PageUrl() ?>start=<?php echo $eventos_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $eventos_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="feventosedit" id="feventosedit" class="form-horizontal ewForm ewEditForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($eventos_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $eventos_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="eventos">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $eventos_edit->HashValue ?>">
<?php if ($eventos->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } ?>
<div>
<?php if ($eventos->Nombre->Visible) { // Nombre ?>
	<div id="r_Nombre" class="form-group">
		<label id="elh_eventos_Nombre" for="x_Nombre" class="col-sm-2 control-label ewLabel"><?php echo $eventos->Nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $eventos->Nombre->CellAttributes() ?>>
<?php if ($eventos->CurrentAction <> "F") { ?>
<span id="el_eventos_Nombre">
<input type="text" data-field="x_Nombre" name="x_Nombre" id="x_Nombre" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($eventos->Nombre->PlaceHolder) ?>" value="<?php echo $eventos->Nombre->EditValue ?>"<?php echo $eventos->Nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_eventos_Nombre">
<span<?php echo $eventos->Nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $eventos->Nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_Nombre" name="x_Nombre" id="x_Nombre" value="<?php echo ew_HtmlEncode($eventos->Nombre->FormValue) ?>">
<?php } ?>
<?php echo $eventos->Nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($eventos->idCliente->Visible) { // idCliente ?>
	<div id="r_idCliente" class="form-group">
		<label id="elh_eventos_idCliente" for="x_idCliente" class="col-sm-2 control-label ewLabel"><?php echo $eventos->idCliente->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $eventos->idCliente->CellAttributes() ?>>
<?php if ($eventos->CurrentAction <> "F") { ?>
<span id="el_eventos_idCliente">
<?php $eventos->idCliente->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x_idCliente']); " . @$eventos->idCliente->EditAttrs["onchange"]; ?>
<select data-field="x_idCliente" id="x_idCliente" name="x_idCliente"<?php echo $eventos->idCliente->EditAttributes() ?>>
<?php
if (is_array($eventos->idCliente->EditValue)) {
	$arwrk = $eventos->idCliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($eventos->idCliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `Id`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clientes`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`Estado`= 'A'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$eventos->Lookup_Selecting($eventos->idCliente, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `RazonSocial` ASC";
?>
<input type="hidden" name="s_x_idCliente" id="s_x_idCliente" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`Id` = {filter_value}"); ?>&amp;t0=3&amp;f1=<?php echo ew_Encrypt("`RazonSocial` IN ({filter_value})"); ?>&amp;t1=200">
</span>
<?php } else { ?>
<span id="el_eventos_idCliente">
<span<?php echo $eventos->idCliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $eventos->idCliente->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idCliente" name="x_idCliente" id="x_idCliente" value="<?php echo ew_HtmlEncode($eventos->idCliente->FormValue) ?>">
<?php } ?>
<?php echo $eventos->idCliente->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($eventos->Descripcion->Visible) { // Descripcion ?>
	<div id="r_Descripcion" class="form-group">
		<label id="elh_eventos_Descripcion" for="x_Descripcion" class="col-sm-2 control-label ewLabel"><?php echo $eventos->Descripcion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $eventos->Descripcion->CellAttributes() ?>>
<?php if ($eventos->CurrentAction <> "F") { ?>
<span id="el_eventos_Descripcion">
<input type="text" data-field="x_Descripcion" name="x_Descripcion" id="x_Descripcion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($eventos->Descripcion->PlaceHolder) ?>" value="<?php echo $eventos->Descripcion->EditValue ?>"<?php echo $eventos->Descripcion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_eventos_Descripcion">
<span<?php echo $eventos->Descripcion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $eventos->Descripcion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_Descripcion" name="x_Descripcion" id="x_Descripcion" value="<?php echo ew_HtmlEncode($eventos->Descripcion->FormValue) ?>">
<?php } ?>
<?php echo $eventos->Descripcion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($eventos->FechaInicio->Visible) { // FechaInicio ?>
	<div id="r_FechaInicio" class="form-group">
		<label id="elh_eventos_FechaInicio" for="x_FechaInicio" class="col-sm-2 control-label ewLabel"><?php echo $eventos->FechaInicio->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $eventos->FechaInicio->CellAttributes() ?>>
<?php if ($eventos->CurrentAction <> "F") { ?>
<span id="el_eventos_FechaInicio">
<input type="text" data-field="x_FechaInicio" name="x_FechaInicio" id="x_FechaInicio" placeholder="<?php echo ew_HtmlEncode($eventos->FechaInicio->PlaceHolder) ?>" value="<?php echo $eventos->FechaInicio->EditValue ?>"<?php echo $eventos->FechaInicio->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_eventos_FechaInicio">
<span<?php echo $eventos->FechaInicio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $eventos->FechaInicio->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_FechaInicio" name="x_FechaInicio" id="x_FechaInicio" value="<?php echo ew_HtmlEncode($eventos->FechaInicio->FormValue) ?>">
<?php } ?>
<?php echo $eventos->FechaInicio->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($eventos->FechaFin->Visible) { // FechaFin ?>
	<div id="r_FechaFin" class="form-group">
		<label id="elh_eventos_FechaFin" for="x_FechaFin" class="col-sm-2 control-label ewLabel"><?php echo $eventos->FechaFin->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $eventos->FechaFin->CellAttributes() ?>>
<?php if ($eventos->CurrentAction <> "F") { ?>
<span id="el_eventos_FechaFin">
<input type="text" data-field="x_FechaFin" name="x_FechaFin" id="x_FechaFin" placeholder="<?php echo ew_HtmlEncode($eventos->FechaFin->PlaceHolder) ?>" value="<?php echo $eventos->FechaFin->EditValue ?>"<?php echo $eventos->FechaFin->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_eventos_FechaFin">
<span<?php echo $eventos->FechaFin->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $eventos->FechaFin->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_FechaFin" name="x_FechaFin" id="x_FechaFin" value="<?php echo ew_HtmlEncode($eventos->FechaFin->FormValue) ?>">
<?php } ?>
<?php echo $eventos->FechaFin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($eventos->Estado->Visible) { // Estado ?>
	<div id="r_Estado" class="form-group">
		<label id="elh_eventos_Estado" for="x_Estado" class="col-sm-2 control-label ewLabel"><?php echo $eventos->Estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $eventos->Estado->CellAttributes() ?>>
<?php if ($eventos->CurrentAction <> "F") { ?>
<span id="el_eventos_Estado">
<select data-field="x_Estado" id="x_Estado" name="x_Estado"<?php echo $eventos->Estado->EditAttributes() ?>>
<?php
if (is_array($eventos->Estado->EditValue)) {
	$arwrk = $eventos->Estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($eventos->Estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php } else { ?>
<span id="el_eventos_Estado">
<span<?php echo $eventos->Estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $eventos->Estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_Estado" name="x_Estado" id="x_Estado" value="<?php echo ew_HtmlEncode($eventos->Estado->FormValue) ?>">
<?php } ?>
<?php echo $eventos->Estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-field="x_Id" name="x_Id" id="x_Id" value="<?php echo ew_HtmlEncode($eventos->Id->CurrentValue) ?>">
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<?php if ($eventos->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_edit.value='overwrite';"><?php echo $Language->Phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnReload" id="btnReload" type="submit" onclick="this.form.a_edit.value='I';"><?php echo $Language->Phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if ($eventos->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_edit.value='F';"><?php echo $Language->Phrase("SaveBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_edit.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
<?php } ?>
	</div>
</div>
</form>
<script type="text/javascript">
feventosedit.Init();
</script>
<?php
$eventos_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$eventos_edit->Page_Terminate();
?>
