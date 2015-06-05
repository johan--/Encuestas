<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg11.php" ?>
<?php include_once "ewmysql11.php" ?>
<?php include_once "phpfn11.php" ?>
<?php include_once "clientesinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn11.php" ?>
<?php

//
// Page class
//

$clientes_add = NULL; // Initialize page object first

class cclientes_add extends cclientes {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ADE930FF-1B1F-40A3-B075-C7C26BDE4A4A}";

	// Table name
	var $TableName = 'clientes';

	// Page object name
	var $PageObjName = 'clientes_add';

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

		// Table object (clientes)
		if (!isset($GLOBALS["clientes"]) || get_class($GLOBALS["clientes"]) == "cclientes") {
			$GLOBALS["clientes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["clientes"];
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
			define("EW_TABLE_NAME", 'clientes', TRUE);

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
		global $EW_EXPORT, $clientes;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($clientes);
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
					$this->Page_Terminate("clienteslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "clientesview.php")
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
		$this->ImagenLogo->Upload->Index = $objForm->Index;
		$this->ImagenLogo->Upload->UploadFile();
	}

	// Load default values
	function LoadDefaultValues() {
		$this->RazonSocial->CurrentValue = NULL;
		$this->RazonSocial->OldValue = $this->RazonSocial->CurrentValue;
		$this->ImagenLogo->Upload->DbValue = NULL;
		$this->ImagenLogo->OldValue = $this->ImagenLogo->Upload->DbValue;
		$this->Comentario->CurrentValue = NULL;
		$this->Comentario->OldValue = $this->Comentario->CurrentValue;
		$this->Estado->CurrentValue = "A";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->RazonSocial->FldIsDetailKey) {
			$this->RazonSocial->setFormValue($objForm->GetValue("x_RazonSocial"));
		}
		if (!$this->Comentario->FldIsDetailKey) {
			$this->Comentario->setFormValue($objForm->GetValue("x_Comentario"));
		}
		if (!$this->Estado->FldIsDetailKey) {
			$this->Estado->setFormValue($objForm->GetValue("x_Estado"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->RazonSocial->CurrentValue = $this->RazonSocial->FormValue;
		$this->Comentario->CurrentValue = $this->Comentario->FormValue;
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
		$this->RazonSocial->setDbValue($rs->fields('RazonSocial'));
		$this->ImagenLogo->Upload->DbValue = $rs->fields('ImagenLogo');
		if (is_array($this->ImagenLogo->Upload->DbValue) || is_object($this->ImagenLogo->Upload->DbValue)) // Byte array
			$this->ImagenLogo->Upload->DbValue = ew_BytesToStr($this->ImagenLogo->Upload->DbValue);
		$this->Comentario->setDbValue($rs->fields('Comentario'));
		$this->Estado->setDbValue($rs->fields('Estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id->DbValue = $row['Id'];
		$this->RazonSocial->DbValue = $row['RazonSocial'];
		$this->ImagenLogo->Upload->DbValue = $row['ImagenLogo'];
		$this->Comentario->DbValue = $row['Comentario'];
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
		// RazonSocial
		// ImagenLogo
		// Comentario
		// Estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// RazonSocial
			$this->RazonSocial->ViewValue = $this->RazonSocial->CurrentValue;
			$this->RazonSocial->ViewCustomAttributes = "";

			// ImagenLogo
			if (!ew_Empty($this->ImagenLogo->Upload->DbValue)) {
				$this->ImagenLogo->ViewValue = $this->ImagenLogo->FldCaption();
			} else {
				$this->ImagenLogo->ViewValue = "";
			}
			$this->ImagenLogo->ViewCustomAttributes = "";

			// Comentario
			$this->Comentario->ViewValue = $this->Comentario->CurrentValue;
			$this->Comentario->ViewCustomAttributes = "";

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

			// RazonSocial
			$this->RazonSocial->LinkCustomAttributes = "";
			$this->RazonSocial->HrefValue = "";
			$this->RazonSocial->TooltipValue = "";

			// ImagenLogo
			$this->ImagenLogo->LinkCustomAttributes = "";
			if (!empty($this->ImagenLogo->Upload->DbValue)) {
				$this->ImagenLogo->HrefValue = "clientes_ImagenLogo_bv.php?Id=" . $this->Id->CurrentValue;
				$this->ImagenLogo->LinkAttrs["target"] = "_blank";
				if ($this->Export <> "") $this->ImagenLogo->HrefValue = ew_ConvertFullUrl($this->ImagenLogo->HrefValue);
			} else {
				$this->ImagenLogo->HrefValue = "";
			}
			$this->ImagenLogo->HrefValue2 = "clientes_ImagenLogo_bv.php?Id=" . $this->Id->CurrentValue;
			$this->ImagenLogo->TooltipValue = "";

			// Comentario
			$this->Comentario->LinkCustomAttributes = "";
			$this->Comentario->HrefValue = "";
			$this->Comentario->TooltipValue = "";

			// Estado
			$this->Estado->LinkCustomAttributes = "";
			$this->Estado->HrefValue = "";
			$this->Estado->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// RazonSocial
			$this->RazonSocial->EditAttrs["class"] = "form-control";
			$this->RazonSocial->EditCustomAttributes = "";
			$this->RazonSocial->EditValue = ew_HtmlEncode($this->RazonSocial->CurrentValue);
			$this->RazonSocial->PlaceHolder = ew_RemoveHtml($this->RazonSocial->FldCaption());

			// ImagenLogo
			$this->ImagenLogo->EditAttrs["class"] = "form-control";
			$this->ImagenLogo->EditCustomAttributes = "";
			if (!ew_Empty($this->ImagenLogo->Upload->DbValue)) {
				$this->ImagenLogo->EditValue = $this->ImagenLogo->FldCaption();
			} else {
				$this->ImagenLogo->EditValue = "";
			}
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->ImagenLogo);

			// Comentario
			$this->Comentario->EditAttrs["class"] = "form-control";
			$this->Comentario->EditCustomAttributes = "";
			$this->Comentario->EditValue = ew_HtmlEncode($this->Comentario->CurrentValue);
			$this->Comentario->PlaceHolder = ew_RemoveHtml($this->Comentario->FldCaption());

			// Estado
			$this->Estado->EditAttrs["class"] = "form-control";
			$this->Estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Estado->FldTagValue(1), $this->Estado->FldTagCaption(1) <> "" ? $this->Estado->FldTagCaption(1) : $this->Estado->FldTagValue(1));
			$arwrk[] = array($this->Estado->FldTagValue(2), $this->Estado->FldTagCaption(2) <> "" ? $this->Estado->FldTagCaption(2) : $this->Estado->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->Estado->EditValue = $arwrk;

			// Edit refer script
			// RazonSocial

			$this->RazonSocial->HrefValue = "";

			// ImagenLogo
			if (!empty($this->ImagenLogo->Upload->DbValue)) {
				$this->ImagenLogo->HrefValue = "clientes_ImagenLogo_bv.php?Id=" . $this->Id->CurrentValue;
				$this->ImagenLogo->LinkAttrs["target"] = "_blank";
				if ($this->Export <> "") $this->ImagenLogo->HrefValue = ew_ConvertFullUrl($this->ImagenLogo->HrefValue);
			} else {
				$this->ImagenLogo->HrefValue = "";
			}
			$this->ImagenLogo->HrefValue2 = "clientes_ImagenLogo_bv.php?Id=" . $this->Id->CurrentValue;

			// Comentario
			$this->Comentario->HrefValue = "";

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
		if (!$this->RazonSocial->FldIsDetailKey && !is_null($this->RazonSocial->FormValue) && $this->RazonSocial->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->RazonSocial->FldCaption(), $this->RazonSocial->ReqErrMsg));
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

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// RazonSocial
		$this->RazonSocial->SetDbValueDef($rsnew, $this->RazonSocial->CurrentValue, "", FALSE);

		// ImagenLogo
		if (!$this->ImagenLogo->Upload->KeepFile) {
			if (is_null($this->ImagenLogo->Upload->Value)) {
				$rsnew['ImagenLogo'] = NULL;
			} else {
				$rsnew['ImagenLogo'] = $this->ImagenLogo->Upload->Value;
			}
		}

		// Comentario
		$this->Comentario->SetDbValueDef($rsnew, $this->Comentario->CurrentValue, NULL, FALSE);

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
				if (!$this->ImagenLogo->Upload->KeepFile) {
				}
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

		// ImagenLogo
		ew_CleanUploadTempPath($this->ImagenLogo, $this->ImagenLogo->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "clienteslist.php", "", $this->TableVar, TRUE);
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
if (!isset($clientes_add)) $clientes_add = new cclientes_add();

// Page init
$clientes_add->Page_Init();

// Page main
$clientes_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$clientes_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var clientes_add = new ew_Page("clientes_add");
clientes_add.PageID = "add"; // Page ID
var EW_PAGE_ID = clientes_add.PageID; // For backward compatibility

// Form object
var fclientesadd = new ew_Form("fclientesadd");

// Validate form
fclientesadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_RazonSocial");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $clientes->RazonSocial->FldCaption(), $clientes->RazonSocial->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $clientes->Estado->FldCaption(), $clientes->Estado->ReqErrMsg)) ?>");

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
fclientesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fclientesadd.ValidateRequired = true;
<?php } else { ?>
fclientesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $clientes_add->ShowPageHeader(); ?>
<?php
$clientes_add->ShowMessage();
?>
<form name="fclientesadd" id="fclientesadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($clientes_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $clientes_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="clientes">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($clientes->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } ?>
<div>
<?php if ($clientes->RazonSocial->Visible) { // RazonSocial ?>
	<div id="r_RazonSocial" class="form-group">
		<label id="elh_clientes_RazonSocial" for="x_RazonSocial" class="col-sm-2 control-label ewLabel"><?php echo $clientes->RazonSocial->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $clientes->RazonSocial->CellAttributes() ?>>
<?php if ($clientes->CurrentAction <> "F") { ?>
<span id="el_clientes_RazonSocial">
<input type="text" data-field="x_RazonSocial" name="x_RazonSocial" id="x_RazonSocial" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($clientes->RazonSocial->PlaceHolder) ?>" value="<?php echo $clientes->RazonSocial->EditValue ?>"<?php echo $clientes->RazonSocial->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_clientes_RazonSocial">
<span<?php echo $clientes->RazonSocial->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $clientes->RazonSocial->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_RazonSocial" name="x_RazonSocial" id="x_RazonSocial" value="<?php echo ew_HtmlEncode($clientes->RazonSocial->FormValue) ?>">
<?php } ?>
<?php echo $clientes->RazonSocial->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($clientes->ImagenLogo->Visible) { // ImagenLogo ?>
	<div id="r_ImagenLogo" class="form-group">
		<label id="elh_clientes_ImagenLogo" class="col-sm-2 control-label ewLabel"><?php echo $clientes->ImagenLogo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $clientes->ImagenLogo->CellAttributes() ?>>
<span id="el_clientes_ImagenLogo">
<div id="fd_x_ImagenLogo">
<span title="<?php echo $clientes->ImagenLogo->FldTitle() ? $clientes->ImagenLogo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($clientes->ImagenLogo->ReadOnly || $clientes->ImagenLogo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-field="x_ImagenLogo" name="x_ImagenLogo" id="x_ImagenLogo">
</span>
<input type="hidden" name="fn_x_ImagenLogo" id= "fn_x_ImagenLogo" value="<?php echo $clientes->ImagenLogo->Upload->FileName ?>">
<input type="hidden" name="fa_x_ImagenLogo" id= "fa_x_ImagenLogo" value="0">
<input type="hidden" name="fs_x_ImagenLogo" id= "fs_x_ImagenLogo" value="0">
<input type="hidden" name="fx_x_ImagenLogo" id= "fx_x_ImagenLogo" value="<?php echo $clientes->ImagenLogo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_ImagenLogo" id= "fm_x_ImagenLogo" value="<?php echo $clientes->ImagenLogo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_ImagenLogo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $clientes->ImagenLogo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($clientes->Comentario->Visible) { // Comentario ?>
	<div id="r_Comentario" class="form-group">
		<label id="elh_clientes_Comentario" for="x_Comentario" class="col-sm-2 control-label ewLabel"><?php echo $clientes->Comentario->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $clientes->Comentario->CellAttributes() ?>>
<?php if ($clientes->CurrentAction <> "F") { ?>
<span id="el_clientes_Comentario">
<textarea data-field="x_Comentario" name="x_Comentario" id="x_Comentario" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($clientes->Comentario->PlaceHolder) ?>"<?php echo $clientes->Comentario->EditAttributes() ?>><?php echo $clientes->Comentario->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_clientes_Comentario">
<span<?php echo $clientes->Comentario->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $clientes->Comentario->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_Comentario" name="x_Comentario" id="x_Comentario" value="<?php echo ew_HtmlEncode($clientes->Comentario->FormValue) ?>">
<?php } ?>
<?php echo $clientes->Comentario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($clientes->Estado->Visible) { // Estado ?>
	<div id="r_Estado" class="form-group">
		<label id="elh_clientes_Estado" for="x_Estado" class="col-sm-2 control-label ewLabel"><?php echo $clientes->Estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $clientes->Estado->CellAttributes() ?>>
<?php if ($clientes->CurrentAction <> "F") { ?>
<span id="el_clientes_Estado">
<select data-field="x_Estado" id="x_Estado" name="x_Estado"<?php echo $clientes->Estado->EditAttributes() ?>>
<?php
if (is_array($clientes->Estado->EditValue)) {
	$arwrk = $clientes->Estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($clientes->Estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<span id="el_clientes_Estado">
<span<?php echo $clientes->Estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $clientes->Estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_Estado" name="x_Estado" id="x_Estado" value="<?php echo ew_HtmlEncode($clientes->Estado->FormValue) ?>">
<?php } ?>
<?php echo $clientes->Estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<?php if ($clientes->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_add.value='F';"><?php echo $Language->Phrase("AddBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_add.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
	</div>
</div>
</form>
<script type="text/javascript">
fclientesadd.Init();
</script>
<?php
$clientes_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$clientes_add->Page_Terminate();
?>
