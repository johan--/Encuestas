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

$eventos_add = NULL; // Initialize page object first

class ceventos_add extends ceventos {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ADE930FF-1B1F-40A3-B075-C7C26BDE4A4A}";

	// Table name
	var $TableName = 'eventos';

	// Page object name
	var $PageObjName = 'eventos_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["Id"] != "") {
				$this->Id->setQueryStringValue($_GET["Id"]);
				$this->setKey("Id", $this->Id->CurrentValue); // Set up key
			} else {
				$this->setKey("Id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("eventoslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "eventosview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		if ($this->CurrentAction == "F") { // Confirm page
		  $this->RowType = EW_ROWTYPE_VIEW; // Render view type
		} else {
		  $this->RowType = EW_ROWTYPE_ADD; // Render add type
		}

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Nombre->CurrentValue = NULL;
		$this->Nombre->OldValue = $this->Nombre->CurrentValue;
		$this->idCliente->CurrentValue = NULL;
		$this->idCliente->OldValue = $this->idCliente->CurrentValue;
		$this->Descripcion->CurrentValue = NULL;
		$this->Descripcion->OldValue = $this->Descripcion->CurrentValue;
		$this->FechaInicio->CurrentValue = NULL;
		$this->FechaInicio->OldValue = $this->FechaInicio->CurrentValue;
		$this->FechaFin->CurrentValue = NULL;
		$this->FechaFin->OldValue = $this->FechaFin->CurrentValue;
		$this->Estado->CurrentValue = "A";
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Nombre->CurrentValue = $this->Nombre->FormValue;
		$this->idCliente->CurrentValue = $this->idCliente->FormValue;
		$this->Descripcion->CurrentValue = $this->Descripcion->FormValue;
		$this->FechaInicio->CurrentValue = $this->FechaInicio->FormValue;
		$this->FechaInicio->CurrentValue = ew_UnFormatDateTime($this->FechaInicio->CurrentValue, 7);
		$this->FechaFin->CurrentValue = $this->FechaFin->FormValue;
		$this->FechaFin->CurrentValue = ew_UnFormatDateTime($this->FechaFin->CurrentValue, 7);
		$this->Estado->CurrentValue = $this->Estado->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id")) <> "")
			$this->Id->CurrentValue = $this->getKey("Id"); // Id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
			$lookuptblfilter = "`Estado` like 'A'";
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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
			$sSqlWrk = "SELECT `Id`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `clientes`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Estado` like 'A'";
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;
		if ($this->idCliente->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(idCliente = " . ew_AdjustSql($this->idCliente->CurrentValue) . ")";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->idCliente->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->idCliente->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Nombre
		$this->Nombre->SetDbValueDef($rsnew, $this->Nombre->CurrentValue, "", FALSE);

		// idCliente
		$this->idCliente->SetDbValueDef($rsnew, $this->idCliente->CurrentValue, 0, FALSE);

		// Descripcion
		$this->Descripcion->SetDbValueDef($rsnew, $this->Descripcion->CurrentValue, NULL, FALSE);

		// FechaInicio
		$this->FechaInicio->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->FechaInicio->CurrentValue, 7), NULL, FALSE);

		// FechaFin
		$this->FechaFin->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->FechaFin->CurrentValue, 7), NULL, FALSE);

		// Estado
		$this->Estado->SetDbValueDef($rsnew, $this->Estado->CurrentValue, "", strval($this->Estado->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->Id->setDbValue($conn->Insert_ID());
			$rsnew['Id'] = $this->Id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "eventoslist.php", "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($eventos_add)) $eventos_add = new ceventos_add();

// Page init
$eventos_add->Page_Init();

// Page main
$eventos_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$eventos_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var eventos_add = new ew_Page("eventos_add");
eventos_add.PageID = "add"; // Page ID
var EW_PAGE_ID = eventos_add.PageID; // For backward compatibility

// Form object
var feventosadd = new ew_Form("feventosadd");

// Validate form
feventosadd.Validate = function() {
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
feventosadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
feventosadd.ValidateRequired = true;
<?php } else { ?>
feventosadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
feventosadd.Lists["x_idCliente"] = {"LinkField":"x_Id","Ajax":true,"AutoFill":false,"DisplayFields":["x_RazonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $eventos_add->ShowPageHeader(); ?>
<?php
$eventos_add->ShowMessage();
?>
<form name="feventosadd" id="feventosadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($eventos_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $eventos_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="eventos">
<input type="hidden" name="a_add" id="a_add" value="A">
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
$sWhereWrk = "";
$lookuptblfilter = "`Estado` like 'A'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$eventos->Lookup_Selecting($eventos->idCliente, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `RazonSocial` ASC";
?>
<input type="hidden" name="s_x_idCliente" id="s_x_idCliente" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`Id` = {filter_value}"); ?>&amp;t0=3">
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
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<?php if ($eventos->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_add.value='F';"><?php echo $Language->Phrase("AddBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_add.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
	</div>
</div>
</form>
<script type="text/javascript">
feventosadd.Init();
</script>
<?php
$eventos_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$eventos_add->Page_Terminate();
?>
